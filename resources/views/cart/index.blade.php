@extends('components.layout')
 
@section('title', 'Mon Panier')
 
@section('content')
 
    <h1>Mon Panier</h1>
 
    @if(session()->has('cart') && count(session('cart')) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Remise</th>
                    <th>Total avec Remise</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $taxRate =  0.14975;
                @endphp
 
                @foreach(session('cart') as $id => $item)
                    @php
                        // remise selon achat de livres
                        $discountPercentage = $item['quantity'] >= 5 ? 15 : ($item['quantity'] >= 3 ? 10 : 5);
                        $discountAmount = ($item['price'] * $item['quantity'] * $discountPercentage) / 100;
                        $totalWithDiscount = ($item['price'] * $item['quantity']) - $discountAmount;
                        $total += $totalWithDiscount;
                    @endphp
                    <tr>
                        <td>{{ $item['title'] }}</td>
                        <td>{{ $item['author'] }}</td>
                        <td>{{ number_format($item['price'], 2) }}$</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control d-inline-block" style="width: 80px;">
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Mettre à jour</button>
                            </form>
                        </td>
                        <td>{{ $discountPercentage }}%</td>
                        <td>{{ number_format($totalWithDiscount, 2) }}$</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
 
                           
 
                        </td>
                    </tr>
                @endforeach
 
                @php
                $taxRate = 0.14975; // Taxes du quebec
            @endphp
           
            <tr>
                <td colspan="5" class="text-right"><strong>Total (sans taxes)</strong></td>
                <td>{{ number_format($total, 2) }}$</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right"><strong>Taxes (14.975%)</strong></td>
                <td>{{ number_format($total * $taxRate, 2) }}$</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right"><strong>Total Général</strong></td>
                <td>{{ number_format($total + ($total * $taxRate), 2) }}$</td>
                <td></td>
            </tr>
           
            </tbody>
        </table>
    @else
        <p>Votre panier est vide.</p>
    @endif
 
    <tr>
        <td colspan="6" class="text-right">
            <a href="{{ route('cart.checkout') }}" class="btn btn-success">Finaliser l'achat</a>
        </td>
    </tr>
 
    <!-- Lien pour revenir à la page d'accueil -->
    <div class="mt-4">
        <a href="{{ route('homepage') }}" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
 
@endsection
 