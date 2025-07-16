<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Marketplace Artisanale')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('boutiques.index') }}">Artisans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('produits.index') }}">Produits</a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Créer un compte</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
        </nav>
    </header>
    <main>
        <div class="container mt-4">
            @yield('content')
        </div>
    </main>
    <footer>
        Copyright © Hestim
    </footer>
</body>
</html>
