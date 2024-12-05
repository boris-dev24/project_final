@extends('components.layout')
 
@section('title', 'Modifier un Livre')
 
@section('content')
<h2 id="edit-title">Modifier le Livre</h2>
<div class="edit-form-container">
    <form id="edit-form" action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
 
        <label for="edit-title-input">Titre :</label>
        <input type="text" id="edit-title-input" name="title" value="{{ $book->title }}" required>
 
        <label for="edit-author-input">Auteur :</label>
        <input type="text" id="edit-author-input" name="author" value="{{ $book->author }}" required>
 
        <label for="edit-year-input">Année :</label>
        <input type="number" id="edit-year-input" name="year" value="{{ $book->year }}" required>
 
        <label for="edit-summary-textarea">Résumé :</label>
        <textarea id="edit-summary-textarea" name="summary" required>{{ $book->summary }}</textarea>
 
        <label for="edit-price-input">Prix :</label>
        <input type="number" id="edit-price-input" name="price" step="0.01" value="{{ $book->price }}" required>
 
        <label for="edit-image-input">Image :</label>
        <input type="file" id="edit-image-input" name="image_path" accept="image/*">
 
        <button id="edit-submit-button" type="submit">Enregistrer les modifications</button>
    </form>
</div>
@endsection