@extends('components.layout') <!-- direction de mon fichier layout ou les repetitions des pages sont -->

@section('title', 'addbook')

@section('content')
    
<div class="form-container">
        <h2>Ajouter un Livre</h2>
        <form action="{{ route('book.store') }}" method="POST" id="add-book-form" enctype="multipart/form-data">  <!-- methode de route complete au lieu de L'URL statique -->
            @csrf <!-- On avait un code 419. https://stackoverflow.com/questions/52583886/post-request-in-laravel-error-419-sorry-your-session-419-your-page-has-exp -->
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" max="200" required>

            <label for="author">Auteur :</label>
            <input type="text" id="author" name="author" max="200" required>

            <label for="year">Année :</label>
            <input type="text" id="year" name="year" min="1000" max="3000" required>

            <label for="summary">Résumé :</label>
            <textarea id="summary" name="summary" rows="5" required></textarea>

            <label for="price">Prix :</label>
            <input type="text" step="0.01" id="price" name="price" required>

           <!-- <label for="date-creation">Date de Création :</label>
            <input type="text" id="date-creation" name="date-creation" readonly>

           
            <label for="date-modification">Date de Modification :</label>
            <input type="text" id="date-modification" name="date-modification" > -->

            <label for="image">Image du Livre :</label>
            <input type="file" id="image" name="image" accept="image/*"> <!-- https://www.w3schools.com/tags/att_input_type_file.asp -->

            <button type="submit">Ajoutez</button>
        </form>
    </div>

   
@endsection