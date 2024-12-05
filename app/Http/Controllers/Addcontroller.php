<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class Addcontroller extends Controller
{
    public function store(Request $request)
    {
        // mes champs des validations du formulaire
        $validatedData = $request->validate([
            'title' => 'required|max:200',
            'author' => 'required|max:200',
            'year' => 'required|integer|min:1000|max:3000', 
            'summary' => 'required|string',
            'price' => 'required|numeric|min:0', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' 
        ]);

        // Gestion de l'upload de l'image

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Obtenir le nom original du fichier
            $imagePath = $image->storeAs('images', $imageName, 'public'); // Stocker avec le nom original
        }



        // CHANGEMENT POUR LUPDATE CAR LARAVEL FAIT QUIL CONVERTI ET DONNE UN AUTRE NOM
       /* $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Stocker dans public/images
        }
*/
        // enregistrement des informations dans ma base de donnee
        Book::create([
            'title' => $validatedData['title'],
            'author' => $validatedData['author'],
            'year' => $validatedData['year'],
            'summary' => $validatedData['summary'],
            'price' => $validatedData['price'],
            'image_path' => $imagePath, // Chemin de l'image dans `public/images`
        ]);

        // Redirection avec message de succès
        return redirect('/')->with('success', 'Livre ajouté!');
    }
}
