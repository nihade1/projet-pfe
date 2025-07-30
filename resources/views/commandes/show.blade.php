@extends('layouts.layout')

@section('title', 'Détails de la commande #' . $commande->id)

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Commande #{{ $commande->id }}</h1>
        <a href="{{ route('commandes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour aux commandes
        </a>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Informations de la commande -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Détails de la commande</h5>
                        <span class="badge bg-{{ $commande->statut === 'livree' ? 'success' : ($commande->statut === 'en_cours' ? 'warning' : 'primary') }}">
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6>Date de commande</h6>
                            <p>{{ $commande->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Numéro de commande</h6>
                            <p>#{{ $commande->id }}</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Prix</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->articles as $article)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($article->produit && $article->produit->photo)
                                                    <img src="{{ asset('storage/' . $article->produit->photo) }}" 
                                                         alt="{{ $article->produit ? $article->produit->nom : 'Produit non disponible' }}" 
                                                         width="50" height="50" class="img-thumbnail me-3" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-light me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-box text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    @if($article->produit)
                                                        <h6 class="mb-0">
                                                            <a href="{{ route('produits.afficher', $article->produit) }}" class="text-dark text-decoration-none">
                                                                {{ $article->produit->nom }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">
                                                            Par <a href="{{ route('boutiques.afficher', $article->produit->boutique) }}">{{ $article->produit->boutique->nom }}</a>
                                                        </small>
                                                    @else
                                                        <p class="mb-0 text-muted">Produit non disponible</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ number_format($article->prix, 2) }} MAD</td>
                                        <td class="text-center align-middle">{{ $article->quantite }}</td>
                                        <td class="text-center align-middle">{{ number_format($article->prix * $article->quantite, 2) }} MAD</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Récapitulatif et adresse -->
        <div class="col-lg-4">
            <!-- Récapitulatif -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Récapitulatif</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total:</span>
                        <span>{{ number_format($commande->montant_total, 2) }} MAD</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Frais de livraison:</span>
                        <span>{{ number_format(0, 2) }} MAD</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span>{{ number_format($commande->montant_total, 2) }} MAD</span>
                    </div>
                </div>
            </div>
            
            <!-- Adresse de livraison -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Adresse de livraison</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">{{ $commande->user->name }}</p>
                    <p class="mb-1">{{ $commande->adresse_livraison }}</p>
                    <p class="mb-1">{{ $commande->code_postal_livraison }} {{ $commande->ville_livraison }}</p>
                    <p class="mb-1">{{ $commande->pays_livraison }}</p>
                    @if($commande->telephone)
                        <p class="mb-0">Tel: {{ $commande->telephone }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
@endsection
