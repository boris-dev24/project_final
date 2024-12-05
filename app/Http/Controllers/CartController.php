<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\LiveEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;


class CartController extends Controller
{
    public function index()
{
    // Récupérer le panier depuis la session
    $cart = session()->get('cart', []);
 
    $cartWithDiscounts = [];
    $grandTotal = 0;
 
    foreach ($cart as $id => $item) {
        $discountPercentage = $this->calculateDiscount($item['quantity']);
        $discountAmount = ($item['price'] * $item['quantity'] * $discountPercentage) / 100;
        $totalWithDiscount = ($item['price'] * $item['quantity']) - $discountAmount;
 
        $cartWithDiscounts[$id] = [
            'title' => $item['title'],
            'author' => $item['author'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'discountPercentage' => $discountPercentage,
            'totalWithDiscount' => $totalWithDiscount,
        ];
 
        $grandTotal += $totalWithDiscount;
    }
 
    return view('cart.index', compact('cartWithDiscounts', 'grandTotal'));
}
 
 
    public function update(Request $request, $id)
    {
        // Récupérer le panier depuis la session
        $cart = session()->get('cart', []);
 
        if(isset($cart[$id])) {
            // Mettre à jour la quantité
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
 
        return redirect()->route('cart.index');
    }
 
    public function remove($id)
    {
        $cart = session()->get('cart', []);
 
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
 
        return redirect()->route('cart.index')->with('success', 'Livre retiré du panier.');
    }
 
    public function checkout()
{
    $user = Auth::user();
    $cartItems = Cart::with('book')->where('user_id', $user->id)->get();
    $total = 0;
    $tax = 0.2; // Exemple de taxe de 20%
    $discount = 0; // Logique de remise si nécessaire

    foreach ($cartItems as $item) {
        $total += $item->book->price * $item->quantity;
    }

    $totalWithTax = $total * (1 + $tax) - $discount; // Calcul avec taxes et remises

    return view('cart.checkout', compact('cartItems', 'total', 'tax', 'discount', 'totalWithTax'));
}

 
    public function addToCart($bookId)
{
    // Récupérer le livre à partir de la base de données
    $book = Book::findOrFail($bookId);
 
    // Récupérer le panier existant ou créer un nouveau panier
    $cart = session()->get('cart', []);
 
    // Si le livre est déjà dans le panier, on met à jour la quantité
    if (isset($cart[$bookId])) {
        $cart[$bookId]['quantity']++;
    } else {
        // Si ce n'est pas le cas, on l'ajoute avec une quantité de 1
        $cart[$bookId] = [
            'title' => $book->title,
            'author' => $book->author,
            'price' => $book->price,
            'quantity' => 1,
        ];
    }
 
    // Mettre à jour le panier dans la session
    session()->put('cart', $cart);
 
    // Rediriger vers la page du panier avec un message de succès
    return redirect()->route('cart.index')->with('success', 'Livre ajouté au panier');
}
 
// DISCOUNT REMISES  
 
private function calculateDiscount($quantity)
{
    if ($quantity >= 5) {
        return 15; // 15% discount 5 livres et plus
    } elseif ($quantity >= 3) {
        return 10; // 10% discount 3 a 4 livres
    } elseif ($quantity >= 1) {
        return 5; // 5% discount 1 a 2 livres
    }
 
    return 0; // Pas de remise
}
 
// EFFACER LE PANIER AU COMPLET
public function clear()
{
    session()->forget('cart');
    return redirect()->route('cart.index')->with('success', 'Panier vidé.');
}

public function processPayment(Request $request)
{
    $user = Auth::user();
    $cartItems = Cart::with('book')->where('user_id', $user->id)->get();

    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item->book->price * $item->quantity;
    }

    $totalWithTax = $total * 1.2; // Ajouter les taxes

    // Configuration de l'environnement PayPal
    $clientId = env('ATzin0r9w3HR9JqVOo776j...');
    $secret = env('EBXni2gEpVT_8s2K2rhL5ekl5KS4FGllO0FbYZvuR7fMyXWZRqvCW2-mkq5hmv0bSGrq6Bet_anFlyVs');
    $environment = new SandboxEnvironment($clientId, $secret);
    $paypalClient = new PayPalHttpClient($environment);

    // Créer la demande de paiement PayPal
    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = [
        'intent' => 'CAPTURE',
        'purchase_units' => [
            0 => [
                'amount' => [
                    'currency_code' => 'EUR',
                    'value' => $totalWithTax
                ],
                'description' => 'Achat de livres'
            ]
        ],
        'application_context' => [
            'return_url' => route('cart.paymentReturn'), // URL de retour après paiement réussi
            'cancel_url' => route('cart.index') // URL en cas d'annulation
        ]
    ];

    try {
        $response = $paypalClient->execute($request);

        // Rediriger l'utilisateur vers PayPal pour le paiement
        foreach ($response->result->links as $link) {
            if ($link->rel == 'approve') {
                return redirect($link->href);
            }
        }
    } catch (Exception $ex) {
        return redirect()->route('cart.index')->with('error', 'Une erreur est survenue pendant le paiement.');
    }
}


public function paymentReturn(Request $request)
{
    $paymentId = $request->get('paymentId');
    $payerId = $request->get('PayerID');

    $clientId = env('ATzin0r9w3HR9JqVOo776j...');
    $secret = env('EBXni2gEpVT_8s2K2rhL5ekl5KS4FGllO0FbYZvuR7fMyXWZRqvCW2-mkq5hmv0bSGrq6Bet_anFlyVs');
    $environment = new SandboxEnvironment($clientId, $secret);
    $paypalClient = new PayPalHttpClient($environment);

    $request = new OrdersCaptureRequest($paymentId);
    $request->prefer('return=representation');

    try {
        $response = $paypalClient->execute($request);

        if ($response->status == 'COMPLETED') {
            // Transaction réussie
            return redirect()->route('cart.index')->with('success', 'Le paiement a été effectué avec succès.');
        } else {
            // Transaction échouée
            return redirect()->route('cart.index')->with('error', 'Le paiement a échoué.');
        }
    } catch (Exception $ex) {
        return redirect()->route('cart.index')->with('error', 'Une erreur est survenue pendant la validation du paiement.');
    }
}


 
 
}



// class CartController extends Controller
// {
//     // public function index()
//     // {
//     //     // Récupérer le panier depuis la session
//     //     $cart = session()->get('cart', []);
//     //     return view('cart.index', compact('cart'));
//     // }

//     public function update(Request $request, $id)
//     {
//         // Récupérer le panier depuis la session
//         $cart = session()->get('cart', []);

//         if(isset($cart[$id])) {
//             // Mettre à jour la quantité
//             $cart[$id]['quantity'] = $request->quantity;
//             session()->put('cart', $cart);
//         }

//         return redirect()->route('cart.index');
//     }

//     public function remove($id)
//     {
//         // Récupérer le panier depuis la session
//         $cart = session()->get('cart', []);

//         if(isset($cart[$id])) {
//             // Supprimer le livre du panier
//             unset($cart[$id]);
//             session()->put('cart', $cart);
//         }

//         return redirect()->route('cart.index');
//     }

//     public function checkout()
//     {
//         // Vous pouvez ajouter une logique ici pour le paiement (par exemple, avec une API de paiement)
//         return view('cart.checkout');
//     }

//     // Ajouter un livre au panier
//     public function addToCart($bookId, Request $request)
//     {
//         // Vérifier que la quantité est bien présente et positive
//         $quantity = $request->input('quantity', 1); // Valeur par défaut de 1 si rien n'est fourni
    
//         // Vérifier que la quantité est un nombre positif
//         if ($quantity <= 0) {
//             return redirect()->back()->with('error', 'La quantité doit être supérieure à zéro.');
//         }
    
//         // Récupérer l'utilisateur connecté
//         $user = Auth::user();
    
//         // Vérifier si le livre existe
//         $book = Book::find($bookId);
    
//         if (!$book) {
//             return redirect()->back()->with('error', 'Le livre n\'existe pas.');
//         }
    
//         // Vérifier si le livre est déjà dans le panier de l'utilisateur
//         $cartItem = Cart::where('user_id', $user->id)
//                         ->where('book_id', $bookId)
//                         ->first();
    
//         if ($cartItem) {
//             // Si le livre est déjà dans le panier, on met à jour la quantité
//             $cartItem->quantity += $quantity; // Ajouter la quantité demandée
//             $cartItem->save();
//         } else {
//             // Si le livre n'est pas dans le panier, on l'ajoute
//             Cart::create([
//                 'user_id' => $user->id,
//                 'book_id' => $bookId,
//                 'quantity' => $quantity, // quantité que l'utilisateur veut ajouter
//             ]);
//         }
    
//         return redirect()->route('cart.index')->with('success', 'Livre ajouté au panier.');
//     }
//     // Afficher le panier de l'utilisateur
//     public function index()
//     {
//         $user = Auth::user();
//         $cartItems = Cart::with('book')->where('user_id', $user->id)->get();
//         return view('cart.index', compact('cartItems'));
//     }

//     public function addToCart($bookId)
// {
//     // Récupérer le livre à partir de la base de données
//     $book = Book::findOrFail($bookId);

//     // Récupérer le panier existant ou créer un nouveau panier
//     $cart = session()->get('cart', []);

//     // Si le livre est déjà dans le panier, on met à jour la quantité
//     if (isset($cart[$bookId])) {
//         $cart[$bookId]['quantity']++;
//     } else {
//         // Si ce n'est pas le cas, on l'ajoute avec une quantité de 1
//         $cart[$bookId] = [
//             'title' => $book->title,
//             'author' => $book->author,
//             'price' => $book->price,
//             'quantity' => 1,
//         ];
//     }

//     // Mettre à jour le panier dans la session
//     session()->put('cart', $cart);

//     // Rediriger vers la page du panier avec un message de succès
//     return redirect()->route('cart.index')->with('success', 'Livre ajouté au panier');
// }
// }
