<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class NouveauteController extends Controller
{
    public function showNouveautes()
    {
        // prend les livres de la base de donne selon la creation 
        $books = Book::orderBy('created_at', 'desc')->get();

        // retourner les livres dans la vue nouveaute
        return view('nouveaute', ['books' => $books]);
    }
}
