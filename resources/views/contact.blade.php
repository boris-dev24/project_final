@extends('components.layout') <!-- direction de mon fichier layout ou les repetitions des pages sont -->

@section('title', 'addbook')

@section('content')

<form action="/contact/submit" method="POST" class="contact-form">
    @csrf<!-- eviter erreur 419-->
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>

    <label for="subject">Sujet :</label>
    <input type="text" id="subject" name="subject" required>

    <label for="message">Message :</label>
    <textarea id="message" name="message" required></textarea>

    <button type="submit" class="btn-submit">Envoyer</button>
</form>


<div class="biblio-info">
    <h3>Informations sur la bibliothèque</h3>
    <p><strong>La Petite Caverne</strong></p>
    <p><strong>Téléphone :</strong> (514) 389-5921</p>
    <p><strong>Adresse :</strong> 9155 Rue St-Hubert, Montréal, QC H2M 1Y8</p>
    <p><strong>Localisez-nous</strong><a class="biblio"  href="https://www.google.com/maps/place/9155+Rue+St-Hubert,+Montr%C3%A9al,+QC+H2M+1Y7/@45.5521049,-73.6428083,17z/data=!3m1!4b1!4m6!3m5!1s0x4cc918db39cee14b:0x8d79af225b5de4f7!8m2!3d45.5521049!4d-73.6428083!16s%2Fg%2F11q2x8p4_j?entry=ttu&g_ep=EgoyMDI0MTIwMy4wIKXMDSoASAFQAw%3D%3D">Cliquez pour nous localiser</a>
</div>

</div>
@endsection