<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message; // Modèle lié à la table messages

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Sauvegarder les données dans la base de données
        Message::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Rediriger vers la page des messages avec un message de succès
        return redirect('/message')->with('success', 'Merci pour votre message.');
    }

    public function showMessages()
    {
        // Récupérer tous les messages de la table messages
        $messages = Message::all();

        // Passer les messages à la vue
        return view('message', ['messages' => $messages]);
    }
}
