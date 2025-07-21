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

<div class="container-fluid py-5 mb-5" style="background-color: #FEF8E9;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Vous êtes artisan ?</h2>
                <p class="mb-4">Créez votre boutique en ligne et présentez vos créations à notre communauté. Bénéficiez d'une plateforme dédiée à l'artisanat et développez votre activité.</p>
                <a href="{{ route('register') }}" class="btn btn-primary">Créer ma boutique</a>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-3">Les avantages pour les artisans</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent d-flex align-items-center border-0 ps-0 py-2">
                                <i class="fas fa-check-circle text-success me-2"></i> Visibilité auprès d'une clientèle ciblée
                            </li>
                            <li class="list-group-item bg-transparent d-flex align-items-center border-0 ps-0 py-2">
                                <i class="fas fa-check-circle text-success me-2"></i> Gestion simplifiée de vos produits
                            </li>
                            <li class="list-group-item bg-transparent d-flex align-items-center border-0 ps-0 py-2">
                                <i class="fas fa-check-circle text-success me-2"></i> Suivi de vos commandes en temps réel
                            </li>
                            <li class="list-group-item bg-transparent d-flex align-items-center border-0 ps-0 py-2">
                                <i class="fas fa-check-circle text-success me-2"></i> Mise en avant de votre savoir-faire
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
