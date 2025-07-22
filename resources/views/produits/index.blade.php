@extends('layouts.layout')

@section('title', 'Produits')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tous les produits</h1>
        
        <!-- Section de filtrage par catégorie -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Rechercher par catégorie</h5>
                <form action="{{ route('produits.index') }}" method="GET">
                    <select name="categorie" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <!-- Affichage du filtre actif -->
        @if(request('categorie'))
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <span class="me-2">Filtre actif :</span>
                        @php
                            $categorieActive = $categories->find(request('categorie'));
                        @endphp
                        @if($categorieActive)
                            <span class="badge bg-success me-2">
                                {{ $categorieActive->nom }}
                                <a href="{{ route('produits.index') }}" class="text-white ms-1">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                        <a href="{{ route('produits.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times"></i> Afficher tous les produits
                        </a>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="row">
            @forelse ($produits as $produit)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $produit->photo ? asset('storage/'.$produit->photo) : asset('images/default-product.jpg') }}" class="card-img-top" alt="{{ $produit->nom }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text text-truncate">{{ $produit->description }}</p>
                            <p class="card-text fw-bold">{{ number_format($produit->prix, 2) }} MAD</p>
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
                    <div class="alert alert-info">
                        Aucun produit disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination avec conservation des filtres -->
        <div class="d-flex justify-content-center mt-4">
            {{ $produits->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

