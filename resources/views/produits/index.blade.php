@extends('layouts.layout')

@section('title', 'Produits')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tous les produits</h1>
        
        <div class="row mb-4">
            <div class="col-md-12">
                <form action="{{ route('recherche') }}" method="GET" class="d-flex">
                    <input type="text" name="requete" class="form-control me-2" placeholder="Rechercher un produit..." value="{{ request('requete') }}">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </form>
            </div>
        </div>
        
        <div class="row">
            @forelse ($produits as $produit)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $produit->image ? asset('storage/'.$produit->image) : asset('images/default-product.jpg') }}" class="card-img-top" alt="{{ $produit->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produit->name }}</h5>
                            <p class="card-text text-truncate">{{ $produit->description }}</p>
                            <p class="card-text fw-bold">{{ number_format($produit->price, 2) }} €</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-sm btn-primary">Voir détails</a>
                                <form action="{{ route('panier.ajouter') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $produit->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-cart-plus"></i> Ajouter
                                    </button>
                                </form>
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
        
        <div class="d-flex justify-content-center mt-4">
            {{ $produits->links() }}
        </div>
    </div>
@endsection

