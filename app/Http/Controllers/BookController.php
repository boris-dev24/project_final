<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
 
class BookController extends Controller
{  /* POUR DETRUIRE */
    public function destroy($id)
    {
        // verification authentification pour voir si role admin
        if (auth()->user()->role !== 'admin') {
           
        }
 
        // recupere le id du livre dans la base de donnee pour leffacer
        $book = Book::findOrFail($id);
        $book->delete();
 
        // Redirige avec un message de succès
        return redirect()->route('homepage')->with('success', 'Livre supprimé');
    }
     /* pour affichier le reste des livres sur la page dacceuil et ceux qui restent dans la base de donne */
    public function index()
    {
        //les livres de ma base de donne table books
        $books = Book::all();
 
        // la vue de mon homepage
        return view('homepage', compact('books'));
    }
 
    /* POUR EDIT LE LIVRE */
 
    public function edit($id)
{
    // Vérifie si l'utilisateur est admin
    if (!auth()->check() || auth()->user()->role !== 'admin') {
     
    }
 
    // prend le id du livre selectionne
    $book = Book::findOrFail($id);
 
    // la vue pour edit le livre
    return view('edit', compact('book'));
}
 
 
 
 
 
/* POUR UPDATE DANS LA BASE DE DONNE VIA LE FORMULAIRE POUR EDIT */
 
public function update(Request $request, $id)
{
    // Vérifie si l'utilisateur est admin
    if (!auth()->check() || auth()->user()->role !== 'admin') {
       
    }
 
    // les memes donnee du formulaire de validation comme quand on ajoute un livre
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'year' => 'required|integer',
        'summary' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
 
    // selection le livre dans la base de donnee selon le id
    $book = Book::findOrFail($id);
 
    //update dans la base de donne
    $book->title = $request->input('title');
    $book->author = $request->input('author');
    $book->year = $request->input('year');
    $book->summary = $request->input('summary');
    $book->price = $request->input('price');
 
    // Gère l'image si elle est téléchargée
    if ($request->hasFile('image_path')) {
        $file = $request->file('image_path');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('images', $originalName, 'public');
        $book->image_path = $path;
    }
   
 
    $book->save();
 
    // Redirige avec un message de succès
    return redirect()->route('homepage')->with('success', 'Livre modifié.');
}
 
 
}