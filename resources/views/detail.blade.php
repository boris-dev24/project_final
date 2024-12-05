@extends('components.layout') <!-- direction de mon fichier layout ou les repetitions des pages sont -->

@section('title', 'addbook')

@section('content')
<div class="booklist">
    @php
        use Illuminate\Support\Facades\File;

        $contents = File::get(base_path('resources/data/books.json'));
        $books = json_decode($contents, true);
    @endphp

    <!-- Implémentation dynamique de mon array de mon fichier Json du livre -->
    @foreach ($books as $book)
    <div class="container">
        <div class="book-card">
            <img src="{{ asset('images/' . $book['image']) }}" alt="{{ e($book['titre']) }} cover">
            <h2>{!! $book['titre'] !!}</h2> <!-- ajout des !! car symbole non désiré -->
            <p><strong>Auteur:</strong> {{ e($book['auteure']) }}</p>
            <p><strong>Résumé:</strong> {!! $book['description'] !!}</p>
            <p><strong>Sujet:</strong> {{ e($book['sujet']) }}</p>
            <p><strong>Prix:</strong> ${{ number_format($book['prix'], 2) }}</p>
            <p><strong>Date de création:</strong> 
                {{ $book['date_creation'] ? \Carbon\Carbon::parse($book['date_creation'])->format('d/m/Y') : '' }}
            </p>
            <p><strong>Date de modification:</strong> 
                {{ $book['date_modification'] ? \Carbon\Carbon::parse($book['date_modification'])->format('d/m/Y') : '' }}
            </p>
        </div>
    </div>
    @endforeach
</div>


<div style="text-align: center; margin-top: 20px;">
    <button type="button" id="back-homepage" onclick="window.location.href='/homepage'">Retour page d'accueil</button>
</div>
@endsection