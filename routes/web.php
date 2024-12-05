<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Addcontroller;  /* importation de mon controleur addcontroller */
use App\Http\Controllers\ContactController; /* importer ContactController */
use App\Http\Controllers\NouveauteController; /* importer Nouveaute Controller */
use App\Http\Controllers\Homepagecontroller; /* importer Homepagecontroller */
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookController; /* importation du bookcontroller pour effacer les livres de la base de donnee */
use App\Http\Controllers\paymentController;
 
/*la route du root du site*/
Route::get('/', function () {
    return view('homepage');
});
 
/*route pour contacter-nous pour que ca affiche contact*/
Route::get('/contact', function () {
    return view('contact');
});
 
/*route pour les messages pour que ca affiche le view des messages*/
Route::get('/message', function () {
    return view('message');
});
 
/* route pour quand je clique sur le boutton ajouter un livre que ca affiche le formulaire qui a comme view addbook*/
Route::get('/addbook', function () {
    return view('addbook');
});
 
 //route pour connecter mon formulaire addbook.php a mon controler Addcontroller qui soccupe dajouter les livres dans ma base de donnee
Route::post('/submit', [Addcontroller::class, 'store'])->name('book.store');
 
 

 
 
 
/*route pour quand je clique sur detail des livres que ca affiche le view detail*/
Route::get('/detail', function () {
    return view('detail');
});
 
 
/*route pour quand je clique sur acceuil que sa affiche view homepage*/
Route::get('/homepage', function () {
    return view('homepage');
});
 
 
 
 
/*routes pour soumettre le formulaire et montrer les messages */
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/message', [ContactController::class, 'showMessages'])->name('messages.show');
 
 
/*route pour nouveaute qui va afficher view nouveaute*/
Route::get('/nouveaute', [NouveauteController::class, 'showNouveautes'])->name('nouveautes.show');


/* route pour afficher les livres de la bases de donnees */
Route::get('/', [Homepagecontroller::class, 'showHomepage'])->name('home'); // note

/* route qui apporte a la recherche des livres hoepagecontroller */
Route::get('/search', [Homepagecontroller::class, 'search'])->name('search');
 

/* route des details des livres   */
Route::get('/books/{id}', [Homepagecontroller::class, 'show'])->name('books.show');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



/* Mettre les routes de l'Auth */
Auth::routes();


/*authentification et enregistrement */
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
/* upodate collone read dans la base de donner des messages */
Route::patch('/messages/{id}', [MessageController::class, 'update'])->name('messages.update'); 


// Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // Afficher le panier
// Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update'); // Mettre à jour la quantité
// Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // Supprimer un livre du panier
// Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // Finaliser l'achat
// Route::get('/cart/add/{bookId}', [CartController::class, 'addToCart'])->name('cart.add'); // ajoute dans le panier

Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // Afficher le panier
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update'); // Mettre à jour la quantité
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // Supprimer un livre du panier
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // Finaliser l'achat
Route::get('/cart/add/{bookId}', [CartController::class, 'addToCart'])->name('cart.add'); // ajoute dans le panier
// Route pour valider le paiement
Route::post('/cart/checkout/pay', [CartController::class, 'processPayment'])->name('cart.processPayment');
// Rediriger après paiement (ce chemin doit correspondre à l'URL que vous avez définie dans PayPal)
Route::get('/checkout/return', [CartController::class, 'paymentReturn'])->name('cart.paymentReturn');


/* pour effacer un livre dans homepage.blade.php */
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
 
/*retour a la page dacceuil apres voir effacer les livres */
Route::get('/', [BookController::class, 'index'])->name('homepage');
/* nouveau formulaire de modification du livre */
Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
 
/* route pour que les updates aillent dans la base de donnee et pour enregistrer les modifications */
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');


Route::post('/pay', [paymentController::class, 'pay'])->name('payment');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
/* pour effacer un message */
Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');