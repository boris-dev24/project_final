<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
 
class MessageController extends Controller
{
    public function update(Request $request, $id)
    {
        // verification role de la personne connecter
        if (auth()->user()->role !== 'admin') {
           
        }
 
        // recuoeration du message via son id
        $message = Message::findOrFail($id);
 
        // ternary pour determiner si le message a ete lu oui ou non
        $message->read = $request->has('read') ? 'oui' : 'non';
        $message->save();
 
        // Redirige avec un message de succès
        return redirect()->back()->with('success', 'Message Lu');
    }
    public function destroy($id)
{
    // Vérifie si l'utilisateur connecté est un administrateur
    if (auth()->user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Action non autorisée.');
    }
 
    // Récupère le message par son ID et le supprime
    $message = Message::findOrFail($id);
    $message->delete();
 
    // Redirige avec un message de succès
    return redirect()->back()->with('success', 'Message supprimé avec succès.');
}
}