<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book; /* import du model Book */
use Illuminate\Http\Request;

class Homepagecontroller extends Controller
{
    public function showHomepage()
    {
        // recuperation des livres de la base de donnee
        $books = Book::all();

        // Affichage des livres de la bd
        return view('homepage', ['books' => $books]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
     
        // Rechercher dans la table books
        $filteredBooks = Book::where('title', 'like', '%' . $query . '%')
        ->orWhere('author', 'like', '%' . $query . '%')
        ->orWhere('year', 'like', '%' . $query . '%')
        ->orWhere('price', 'like', '%' . $query . '%')
        ->get();
        // Passer les résultats filtrés à la vue
        return view('homepage', ['books' => $filteredBooks]);

        
    }
  
    public function show($id)
{
    // Récupérer le livre avec l'ID spécifié
    $book = Book::findOrFail($id); // Utilisation de findOrFail pour retourner une erreur si le livre n'est pas trouvé
 
    // Passer les détails du livre à la vue
    return view('show', ['book' => $book]);
}
}
