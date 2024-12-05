@extends('components.layout') <!-- direction de mon fichier layout ou les repetitions des pages sont -->

@section('title', 'Homepage')

@section('content')

@if(Auth::check() && Auth::user()->role === 'admin')
<button type="button" id="add-book" onclick="window.location.href='/addbook'">Ajouter un Livre</button>
@endif

<!-- <button type="button" id="motify-book" onclick="window.location.href='/detail'">Details des livres</button> -->
<button type="button" id="new-book" onclick="window.location.href='/nouveaute'">Nouveauté</button>

<div class="search-bar">
    <form action="/search" method="GET"> <!-- GET car lire une info sans la modifier-->
        <input type="text" name="query" placeholder="Rechercher un livre" required>
        <button type="submit">Rechercher</button>
    </form>
</div>

<div class="booklist">
    <!-- Parcourir les livres depuis la base de données -->
    @foreach ($books as $book)
        <div class="container">
            <div class="book-card">
                <!-- Affiche l'image en utilisant image_path -->
                <img src="{{ asset($book->image_path) }}" alt="{{ e($book->title) }} cover">
                
                <!-- Affiche les informations du livre -->
                <h2>{{ $book->title }}</h2>
                <p><strong>Auteur:</strong> {{ $book->author }}</p>
                <p><strong>Année:</strong> {{ $book->year }}</p>
                <p><strong>Résumé:</strong> {{ $book->summary }}</p>
                <p><strong>Prix:</strong> ${{ number_format($book->price, 2) }}</p>
            </div>

              <!-- pour effacer un livre en tant que administateur avec laffichage du bouton delete -->
 
              @if (Auth::check() && Auth::user()->role === 'admin')
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Supprimer ce livre?')">
                            Effacer
                        </button>
                    </form>
                    <!-- modification du livre -->
                   <!-- Bouton Modifier -->
               <a href="{{ route('books.edit', $book->id) }}" class="btn-edit">
                  <button type="button">Modifier</button>
               </a>
                @endif

            <a href="{{ route('books.show', $book->id) }}" class="btn-detail">
                <button>Détails</button>
            </a>
            <form action="{{ route('cart.add', $book->id) }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-primary" id="new-book">Ajouter au panier</button>
        </form>
        </div>
    @endforeach
</div>
@endsection
