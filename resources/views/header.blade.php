</head>
<body>
    <header>
        
        <nav>
            <h1> La petite Caverne</h1>
            <ul>
                <li><a href="/">Accueil</a></li> <!-- mettre la route au lieu du # -->
                <li><a href="/contact">Contactez-nous</a></li>
                <li><a href="/message">Messages</a></li>


                @guest
                <!-- Liens pour les invités (utilisateurs non connectés) -->
                <li><a href="{{ route('login') }}">Se connecter</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}">S'inscrire</a></li>
                @endif
            @else
                <!-- Liens pour les utilisateurs connectés -->
                <li>
                    <span>Bienvenue, {{ Auth::user()->name }}</span>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest

            <!-- Lien vers le panier -->
            <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            Panier
                            <!-- Affichage du nombre d'articles dans le panier -->
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
            </li>
        </ul>




            </ul>
            <!-- <div class="search-bar">
                <form action="/search" method="GET">     -->                       <!-- GET car lire une info sans la modifier-->
             <!--       <input type="text" name="query" placeholder="Rechercher un livre" required>
                    <button type="submit">Rechercher</button>
                </form>
            </div>  -->
        </nav>
    </header>


    