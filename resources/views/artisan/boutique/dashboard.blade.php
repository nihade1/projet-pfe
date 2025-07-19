@extends('layouts.layout')

@section('title', 'Tableau de bord - Ma boutique')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar de navigation -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ma boutique</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('artisan.boutique.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home me-2"></i> Tableau de bord
                    </a>
                    <a href="{{ route('artisan.produits.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-box me-2"></i> Mes produits
                    </a>
                    <a href="{{ route('artisan.commandes.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart me-2"></i> Commandes
                    </a>
                    <a href="{{ route('artisan.boutique.editer') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-edit me-2"></i> Modifier ma boutique
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Contenu principal -->
        <div class="col-md-9">
            <!-- Messages de notification -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-check-circle"></i></strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Informations de la boutique -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex">
                        @if($boutique->photo)
                            <img src="{{ asset('storage/' . $boutique->photo) }}" alt="{{ $boutique->nom }}" class="img-thumbnail me-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light me-3 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                <i class="fas fa-store fa-3x text-secondary"></i>
                            </div>
                        @endif
                        <div>
                            <h1 class="h3 mb-2">{{ $boutique->nom }}</h1>
                            <p class="text-muted mb-3">Créée le {{ $boutique->created_at->format('d/m/Y') }}</p>
                            <a href="{{ route('artisan.boutique.editer') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="{{ route('boutiques.afficher', $boutique) }}" class="btn btn-sm btn-outline-primary ms-2">
                                <i class="fas fa-eye"></i> Voir en tant que client
                            </a>
                            <a href="{{ route('artisan.produits.creer') }}" class="btn btn-sm btn-success ms-2">
                                <i class="fas fa-plus"></i> Ajouter un produit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Produits</h6>
                                    <h2 class="mb-0">{{ $produits->count() }}</h2>
                                </div>
                                <i class="fas fa-box fa-2x opacity-50"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-primary bg-opacity-75 py-1">
                            <a href="{{ route('artisan.produits.index') }}" class="text-white small stretched-link text-decoration-none">Voir tous <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Commandes</h6>
                                    <h2 class="mb-0">{{ $commandes->count() }}</h2>
                                </div>
                                <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-success bg-opacity-75 py-1">
                            <a href="{{ route('artisan.commandes.index') }}" class="text-white small stretched-link text-decoration-none">Voir toutes <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Avis</h6>
                                    <h2 class="mb-0">0</h2> <!-- À remplacer par le nombre réel d'avis -->
                                </div>
                                <i class="fas fa-star fa-2x opacity-50"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-info bg-opacity-75 py-1">
                            <a href="#" class="text-white small stretched-link text-decoration-none">Voir tous <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derniers produits -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Derniers produits</h5>
                    <a href="{{ route('artisan.produits.creer') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un produit
                    </a>
                </div>
                <div class="card-body">
                    @if($produits->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <p class="lead">Vous n'avez pas encore de produits</p>
                            <a href="{{ route('artisan.produits.creer') }}" class="btn btn-primary">
                                Ajouter votre premier produit
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits->take(5) as $produit)
                                        <tr>
                                            <td>
                                                @if($produit->photo)
                                                    <img src="{{ asset('storage/' . $produit->photo) }}" alt="{{ $produit->nom }}" width="40" height="40" class="img-thumbnail">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-box text-secondary"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $produit->nom }}</td>
                                            <td>{{ $produit->prix }} €</td>
                                            <td>{{ $produit->stock }}</td>
                                            <td>
                                                <a href="{{ route('artisan.produits.editer', $produit) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-sm btn-outline-primary ms-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($produits->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('artisan.produits.index') }}" class="btn btn-outline-primary btn-sm">Voir tous les produits</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Dernières commandes -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Dernières commandes</h5>
                </div>
                <div class="card-body">
                    @if($commandes->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="lead">Vous n'avez pas encore reçu de commandes</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes as $commande)
                                        <tr>
                                            <td>#{{ $commande->id }}</td>
                                            <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $commande->user->name }}</td>
                                            <td>{{ $commande->montant_total }} €</td>
                                            <td>
                                                <span class="badge bg-{{ $commande->statut === 'en_attente' ? 'warning' : ($commande->statut === 'expediee' ? 'info' : ($commande->statut === 'livree' ? 'success' : 'secondary')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('artisan.commandes.afficher', $commande) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('artisan.commandes.index') }}" class="btn btn-outline-primary btn-sm">Voir toutes les commandes</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
