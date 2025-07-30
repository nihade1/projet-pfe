@extends('layouts.layout')

@section('title', 'Produits - ' . $categorie->nom)

@section('content')
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i> Retour aux produits
            </a>
            <div>
                <h1 class="mb-1">{{ $categorie->nom }}</h1>
                <p class="text-muted mb-0">{{ $produits->total() }} produit(s) trouvé(s)</p>
            </div>
        </div>
        
        <!-- Navigation entre catégories -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h5 class="mb-3"><i class="fas fa-exchange-alt me-2"></i>Changer de catégorie</h5>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ $categorie->nom }} <span class="badge bg-primary ms-2">{{ $produits->total() }} produit(s)</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('produits.index') }}">Toutes les catégories</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach($categories as $cat)
                            <li>
                                <a class="dropdown-item {{ $cat->id == $categorie->id ? 'active' : '' }}" 
                                   href="{{ route('categories.produits', $cat) }}">
                                    {{ $cat->nom }}
                                    @if($cat->id == $categorie->id)
                                        <i class="fas fa-check float-end"></i>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Grille des produits -->
        <div class="row">
            @forelse ($produits as $produit)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $produit->photo ? asset('storage/'.$produit->photo) : asset('images/default-product.jpg') }}" class="card-img-top" alt="{{ $produit->nom }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text text-truncate">{{ $produit->description }}</p>
                            <p class="card-text fw-bold">{{ number_format($produit->prix, 2) }} MAD</p>
                            <div class="text-muted small mb-2">
                                <i class="fas fa-store"></i> {{ $produit->boutique->nom }}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-sm btn-primary">Voir détails</a>
                                @auth
                                    <form action="{{ route('panier.ajouter') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                        <input type="hidden" name="quantite" value="1">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-cart-plus"></i> Ajouter
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-success" title="Connectez-vous pour ajouter au panier">
                                        <i class="fas fa-cart-plus"></i> Ajouter
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                        <h4>Aucun produit disponible</h4>
                        <p>Aucun produit n'est disponible dans la catégorie {{ $categorie->nom }} pour le moment.</p>
                        <a href="{{ route('produits.index') }}" class="btn btn-primary">Voir tous les produits</a>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($produits->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $produits->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> f14d6e86921ec78b7ed3de73598425023182ff8e
