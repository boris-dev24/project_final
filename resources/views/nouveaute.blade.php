@extends('components.layout')

@section('title', 'Nouveautés')

@section('content')
    <h2>Livres Nouveautés</h2>
    <div class="booklist">
        @if($books->count() > 0)
            @foreach ($books as $book)
                <div class="container">
                    <div class="book-card">
                        <img src="{{ asset($book->image_path) }}" alt="{{ e($book->title) }} cover">
                        <h2>{{ $book->title }}</h2>
                        <p><strong>Auteur:</strong> {{ $book->author }}</p>
                        <p><strong>Résumé:</strong> {{ $book->summary }}</p>
                        <p><strong>Prix:</strong> ${{ number_format($book->price, 2) }}</p>
                 <!--       <p><strong>Date de création:</strong> 
                            {{ $book->created_at->format('d/m/Y') }}
                        </p>   -->
                    </div>
                    <a href="{{ route('books.show', $book->id) }}" class="btn-detail">
                        <button>Détails</button>
                    </a>
                </div>
            @endforeach
        @else
            <p>Aucun livre trouvé.</p>
        @endif
    </div>
@endsection
