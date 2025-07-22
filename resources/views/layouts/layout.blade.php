<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArtisanMarket - Marketplace Artisanale')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="ArtisanMarket Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('boutiques.*') ? 'active' : '' }}" href="{{ route('boutiques.index') }}">Artisans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}" href="{{ route('produits.index') }}">Produits</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                                Catégories
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('produits.index') }}">Toutes les catégories</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @php
                                    $categories = \App\Models\Categorie::all();
                                @endphp
                                @foreach($categories as $cat)
                                    <li><a class="dropdown-item" href="{{ route('categories.produits', $cat) }}">{{ $cat->nom }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('panier.*') ? 'active' : '' }} cart-icon" 
                               href="{{ Auth::check() ? route('panier.index') : route('login') }}"
                               title="{{ Auth::check() ? 'Voir mon panier' : 'Connectez-vous pour accéder à votre panier' }}">
                                <i class="fas fa-shopping-cart"></i> Panier
                                @if(session()->has('panier') && count(session('panier')) > 0)
                                    <span class="cart-badge">{{ count(session('panier')) }}</span>
                                @endif
                            </a>
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
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>ArtisanMarket</h5>
                    <p>Découvrez des produits uniques, trouvez votre artisan préféré ou créez votre propre boutique !</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('index') }}" class="text-white">Accueil</a></li>
                        <li><a href="{{ route('boutiques.index') }}" class="text-white">Artisans</a></li>
                        <li><a href="{{ route('produits.index') }}" class="text-white">Produits</a></li>
                        <li><a href="{{ route('panier.index') }}" class="text-white">Panier</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Suivez-nous</h5>
                    <div class="d-flex gap-3 fs-4">
                        <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-3" style="border-color: rgba(255,255,255,0.2);">
            <p class="text-center mb-0">&copy; {{ date('Y') }} ArtisanMarket - Tous droits réservés</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>