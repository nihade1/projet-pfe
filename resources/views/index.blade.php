@extends('layouts.layout')

@section('title', 'ArtisanMarket - Marketplace Artisanale')

@section('content')
<div class="hero-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7 mb-5 mb-md-0">
                <h1>Bienvenue sur ArtisanMarket</h1>
                <p class="fs-5 mb-5">Découvrez des produits uniques, trouvez votre artisan préféré ou créez votre propre boutique !</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('produits.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i> Voir les produits
                    </a>
                    <a href="{{ route('boutiques.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-store me-2"></i> Explorer les artisans
                    </a>
                </div>
            </div>
            <div class="col-md-5">
                <div class="text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="ArtisanMarket" class="img-fluid" style="max-width: 350px; background-color: #FEF8E9; padding: 20px; border-radius: 5px;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h2 class="text-center section-title">Découvrez notre sélection</h2>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="fas fa-hand-holding-heart fa-3x text-primary mb-3"></i>
                    <h3 class="card-title">Artisanat local</h3>
                    <p class="card-text">Des produits fabriqués avec passion par des artisans locaux.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="fas fa-certificate fa-3x text-primary mb-3"></i>
                    <h3 class="card-title">Qualité garantie</h3>
                    <p class="card-text">Des pièces uniques et authentiques au savoir-faire exceptionnel.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="card-title">Communauté</h3>
                    <p class="card-text">Rejoignez notre communauté d'artisans et de clients passionnés.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Catégories -->
<div class="container mb-5">
    <h2 class="text-center section-title">Explorez nos catégories</h2>
    <div class="row g-3">
        @foreach($categories->take(8) as $categorie)
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('categories.produits', $categorie) }}" class="text-decoration-none">
                    <div class="card category-card h-100 text-center border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="category-icon mb-2">
                                @switch($categorie->nom)
                                    @case('Décoration')
                                        <i class="fas fa-home fa-2x text-primary"></i>
                                        @break
                                    @case('Bijoux faits main')
                                        <i class="fas fa-gem fa-2x text-primary"></i>
                                        @break
                                    @case('Vêtements artisanaux')
                                        <i class="fas fa-tshirt fa-2x text-primary"></i>
                                        @break
                                    @case('Accessoires en cuir')
                                        <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                                        @break
                                    @case('Céramiques')
                                        <i class="fas fa-vase-plant fa-2x text-primary"></i>
                                        @break
                                    @case('Textiles tissés')
                                        <i class="fas fa-cut fa-2x text-primary"></i>
                                        @break
                                    @case('Cosmétiques naturels')
                                        <i class="fas fa-spa fa-2x text-primary"></i>
                                        @break
                                    @case('Objets en bois')
                                        <i class="fas fa-tree fa-2x text-primary"></i>
                                        @break
                                    @case('Papeterie & Cartes')
                                        <i class="fas fa-envelope fa-2x text-primary"></i>
                                        @break
                                    @case('Produits locaux (épices, miel, etc.)')
                                        <i class="fas fa-seedling fa-2x text-primary"></i>
                                        @break
                                    @default
                                        <i class="fas fa-star fa-2x text-primary"></i>
                                @endswitch
                            </div>
                            <h6 class="card-title mb-1">{{ $categorie->nom }}</h6>
                            <small class="text-muted">{{ $categorie->produits_count }} produit(s)</small>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
            Voir toutes les catégories <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
</div>
@endsection
