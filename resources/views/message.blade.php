@extends('components.layout') <!-- direction de mon fichier layout ou les repetitions des pages sont -->
 
@section('title', 'Messages')
 
@section('content')
    <h2 id="msg">Messages</h2>
    <div class="message-container">
        @foreach ($messages as $message)
            <div class="message-card">
                <p><strong>Nom :</strong> {{ e($message->name) }}</p>
                <p><strong>Email :</strong> {{ e($message->email) }}</p>
                <p><strong>Sujet :</strong> {{ e($message->subject) }}</p>
                <p><strong>Message :</strong> {{ e($message->message) }}</p>
 
                <!-- affichage si le user a un role de admin-->
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <form action="{{ route('messages.update', $message->id) }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        @method('PATCH')
                        <p>
                            <strong>Lu :</strong>
                            <label>
                                <input
                                    type="checkbox"
                                    name="read"
                                    value="oui"
                                    {{ $message->read === 'oui' ? 'checked' : '' }}
                                    onchange="this.form.submit()"
                                >
                               
                            </label>
                        </p>
                    </form>
                @endif
                @if (Auth::check() && Auth::user()->role === 'admin')
    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" style="margin-top: 10px;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Vous voulez supprimer ce message ?')" class="btn btn-danger">
            Supprimer
        </button>
    </form>
@endif
            </div>
        @endforeach
    </div>
@endsection
 