@extends('components.layout')

@section('title', 'Paiement')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container">
    <h1>Page de Paiement</h1>

    <!-- Afficher le résumé de l'achat -->
    <div>
        <h3>Résumé de votre commande</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->book->title }}</td>
                        <td>{{ $item->book->author }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->book->price, 2) }}$</td>
                        <td>{{ number_format($item->book->price * $item->quantity, 2) }}€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <p><strong>Total HT :</strong> {{ number_format($total, 2) }}$</p>
            <p><strong>Taxes (20%) :</strong> {{ number_format($total * 0.2, 2) }}$</p>
            <p><strong>Total avec taxes :</strong> {{ number_format($total * 1.2, 2) }}$</p>
        </div>

        <!-- Formulaire PayPal -->
        <div class="mt-4">
            <form action="{{ route('payment') }}" method="POST">
                @csrf
                <input type='hidden' name='amount' value='200'>
                <button type="submit" class="btn btn-success">Payer avec PayPal</button>
            </form>
        </div>
    </div>
</div>
@endsection
