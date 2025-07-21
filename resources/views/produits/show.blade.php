@extends('layouts.layout')

@section('title', $produit->nom)

@section('content')
<div class="container py-5">
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produits.index') }}">Produits</a></li>
            <li class="breadcrumb-item"><a href="{{ route('boutiques.afficher', $produit->boutique) }}">{{ $produit->boutique->nom }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produit->nom }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Images du produit -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    @if($produit->photo)
                        <img src="{{ asset('storage/' . $produit->photo) }}" class="img-fluid rounded" alt="{{ $produit->nom }}" style="max-height: 400px; width: 100%; object-fit: contain;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center" style="height: 400px;">
                            <i class="fas fa-box fa-4x text-secondary"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Informations du produit -->
        <div class="col-md-6">
            <h1 class="mb-2">{{ $produit->nom }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-primary">{{ $produit->categorie->nom }}</span>
                <span class="ms-2 text-muted">Par <a href="{{ route('boutiques.afficher', $produit->boutique) }}">{{ $produit->boutique->nom }}</a></span>
            </div>
            
            <div class="mb-3">
                @if($produit->avis->count() > 0)
                    @php
                        $moyenne = $produit->avis->avg('note');
                        $nbAvis = $produit->avis->count();
                    @endphp
                    <div class="d-flex align-items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($moyenne) ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <span class="ms-2">{{ number_format($moyenne, 1) }}/5 ({{ $nbAvis }} avis)</span>
                    </div>
                @else
                    <div class="text-muted">
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <span class="ms-2">Aucun avis pour le moment</span>
                    </div>
                @endif
            </div>
            
            <div class="mb-4">
                <h2 class="h1 text-primary">{{ number_format($produit->prix, 2) }} €</h2>
                <p class="text-muted">
                    {{ $produit->stock > 0 ? 'En stock (' . $produit->stock . ' disponibles)' : 'Épuisé' }}
                </p>
            </div>
            
            <form method="POST" action="{{ route('panier.ajouter') }}" class="mb-4">
                @csrf
                <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                <div class="row g-2 align-items-center">
                    <div class="col-4">
                        <div class="input-group">
                            <span class="input-group-text">Qté</span>
                            <input type="number" class="form-control" name="quantite" value="1" min="1" max="{{ $produit->stock }}" {{ $produit->stock <= 0 ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="col-8">
                        <button type="submit" class="btn btn-success w-100" {{ $produit->stock <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart me-2"></i> Ajouter au panier
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p>{{ $produit->description }}</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-truck text-primary me-2"></i>
                <span>Expédition sous 2-3 jours ouvrables</span>
            </div>
            
            <div class="d-flex align-items-center">
                <i class="fas fa-shield-alt text-primary me-2"></i>
                <span>Garantie satisfaction ou remboursement</span>
            </div>
        </div>
    </div>
    
    <!-- Onglets pour les détails et avis -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Détails</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Avis ({{ $produit->avis->count() }})</button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabContent">
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Caractéristiques du produit</h5>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Catégorie</th>
                                        <td>{{ $produit->categorie->nom }}</td>
                                    </tr>
                                    <tr>
                                        <th>Artisan</th>
                                        <td>{{ $produit->boutique->artisan->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Boutique</th>
                                        <td>{{ $produit->boutique->nom }}</td>
                                    </tr>
                                    <tr>
                                        <th>Disponibilité</th>
                                        <td>{{ $produit->stock > 0 ? 'En stock' : 'Épuisé' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>À propos de l'artisan</h5>
                            <p>
                                {{ $produit->boutique->artisan->bio ?? 'Cet artisan n\'a pas encore ajouté de bio.' }}
                            </p>
                            <a href="{{ route('boutiques.afficher', $produit->boutique) }}" class="btn btn-outline-primary">
                                <i class="fas fa-store me-1"></i> Visiter la boutique
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    @if($produit->avis->count() > 0)
                        <div class="mb-4">
                            <h5>Tous les avis ({{ $produit->avis->count() }})</h5>
                            <div class="list-group">
                                @foreach($produit->avis as $avis)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $avis->user->name }}</strong>
                                                <small class="text-muted ms-2">{{ $avis->created_at->format('d/m/Y') }}</small>
                                            </div>
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $avis->note ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        @if($avis->commentaire)
                                            <p class="mt-2 mb-0">{{ $avis->commentaire }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Ce produit n'a pas encore reçu d'avis.
                        </div>
                    @endif

                    @auth
                        <div class="card mt-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Laisser un avis</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('produits.avis', $produit) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Note</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="note" id="note1" value="1" required>
                                                <label class="form-check-label" for="note1">1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="note" id="note2" value="2">
                                                <label class="form-check-label" for="note2">2</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="note" id="note3" value="3">
                                                <label class="form-check-label" for="note3">3</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="note" id="note4" value="4">
                                                <label class="form-check-label" for="note4">4</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="note" id="note5" value="5">
                                                <label class="form-check-label" for="note5">5</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                                        <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Envoyer mon avis</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un avis sur ce produit.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Produits similaires -->
    @if($produitsRelies->count() > 0)
        <div class="mt-5">
            <h3 class="mb-4">Vous pourriez aussi aimer</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach($produitsRelies as $produitRelie)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @if($produitRelie->photo)
                                <img src="{{ asset('storage/' . $produitRelie->photo) }}" class="card-img-top" alt="{{ $produitRelie->nom }}" style="height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-light text-center p-3">
                                    <i class="fas fa-box fa-3x text-secondary"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $produitRelie->nom }}</h5>
                                <p class="card-text fw-bold text-primary">{{ number_format($produitRelie->prix, 2) }} €</p>
                            </div>
                            <div class="card-footer bg-white border-top-0 pt-0">
                                <a href="{{ route('produits.afficher', $produitRelie) }}" class="btn btn-outline-primary btn-sm">Voir le produit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
