@extends('layouts.layout')

@section('title', 'Mon panier')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Mon panier</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(count($produits) > 0)
        <div class="row">
            <!-- Tableau des articles -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Produit</th>
                                        <th class="border-0 text-center">Prix unitaire</th>
                                        <th class="border-0 text-center">Quantité</th>
                                        <th class="border-0 text-center">Total</th>
                                        <th class="border-0 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits as $produit)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    @if($produit->photo)
                                                        <img src="{{ asset('storage/' . $produit->photo) }}" alt="{{ $produit->nom }}" width="60" height="60" class="img-thumbnail me-3" style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-light me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fas fa-box text-secondary"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">
                                                            <a href="{{ route('produits.afficher', $produit) }}" class="text-dark text-decoration-none">
                                                                {{ $produit->nom }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">
                                                            Par <a href="{{ route('boutiques.afficher', $produit->boutique) }}">{{ $produit->boutique->nom }}</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">{{ number_format($produit->prix, 2) }} MAD</td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('panier.mettreAJour', $produit->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        <button type="button" class="btn btn-outline-secondary btn-qty-minus">-</button>
                                                        <input type="number" name="quantite" value="{{ $panier[$produit->id] }}" min="1" max="{{ $produit->stock }}" class="form-control text-center qty-input">
                                                        <button type="button" class="btn btn-outline-secondary btn-qty-plus">+</button>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-2 w-100">Mettre à jour</button>
                                                </form>
                                            </td>
                                            <td class="text-center align-middle fw-bold">{{ number_format($produit->prix * $panier[$produit->id], 2) }} MAD</td>
                                            <td class="text-end align-middle">
                                                <form action="{{ route('panier.supprimer', $produit->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Continuer mes achats
                    </a>
                    <form action="{{ route('panier.vider') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash me-1"></i> Vider le panier
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Récapitulatif de la commande -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Récapitulatif</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total:</span>
                            <span>{{ number_format($total, 2) }} MAD</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Frais de livraison:</span>
                            <span>{{ number_format(0, 2) }} MAD</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4 fw-bold">
                            <span>Total:</span>
                            <span>{{ number_format($total, 2) }} MAD</span>
                        </div>
                        
                        <a href="{{ route('commandes.paiement') }}" class="btn btn-success w-100">
                            <i class="fas fa-lock me-1"></i> Procéder au paiement
                        </a>
                    </div>
                </div>
                
                <div class="card mt-3 shadow-sm">
                    <div class="card-body">
                        <h6>Nous acceptons</h6>
                        <div class="d-flex gap-2">
                            <i class="fab fa-cc-visa fa-2x text-primary"></i>
                            <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                            <i class="fab fa-cc-paypal fa-2x text-info"></i>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-truck text-success me-3"></i>
                            <span>Livraison offerte à partir de 500 MAD</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-undo text-success me-3"></i>
                            <span>Retours gratuits sous 14 jours</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lock text-success me-3"></i>
                            <span>Paiement 100% sécurisé</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h3 class="mb-3">Votre panier est vide</h3>
                <p class="mb-4">Découvrez nos produits artisanaux et ajoutez-les à votre panier.</p>
                <a href="{{ route('produits.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-1"></i> Voir les produits
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des boutons + et - pour les quantités
    document.querySelectorAll('.btn-qty-minus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.qty-input');
            const value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });
    });

    document.querySelectorAll('.btn-qty-plus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.qty-input');
            const value = parseInt(input.value);
            const max = parseInt(input.getAttribute('max'));
            if (value < max) {
                input.value = value + 1;
            }
        });
    });
});
</script>
@endpush
@endsection
