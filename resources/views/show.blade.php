 
@extends('components.layout')
 
@section('title', 'addbook')
 
@section('content')
<div class="container mt-5">
<h1>Détails du livre</h1>
<div class="card mb-3" style="max-width: 960px;">
        <div class="row no-gutters">
            <div class="col-md-4">
               
                @if ($book->image_path)
                    <img src="{{ asset($book->image_path) }}" alt="{{ e($book->title) }} cover">
                @endif
            </div>
            <div class="card-body">
                <h2 class="card-title">{{ $book->title }}</h2>
                <p class="card-text"><strong>Auteur :</strong> {{ $book->author }}</p>
                <p class="card-text"><strong>Année :</strong> {{ $book->year }}</p>
                <p class="card-text"><strong>Prix :</strong> {{ $book->price }} $</p>
                <p class="card-text"><strong>Résumé :</strong> {{ $book->summary }}</p>
                <!-- <p class="card-text"><strong>Cree le :</strong> {{ $book->created_at }}</p> -->
                <!-- <p class="card-text"><strong>Modifier le :</strong> {{ $book->updated_at }}</p> -->
                <a href="{{ url('/') }}"class="btn-back">Retour à la liste</a> <!-- Permet de revenir à la page précédente -->
            </div>
        </div>
    </div>
    </div>
    </div>
    @endsection  
 