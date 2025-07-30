@extends('layouts.layout')

@section('title', 'Profil Artisan')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Bienvenue dans votre profil artisan, {{ $user->name }}</h1>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Informations personnelles</h5>
                            <div class="d-flex align-items-center mb-3">
                                @if($artisan->photo)
                                    <img src="{{ asset('storage/' . $artisan->photo) }}" alt="{{ $user->name }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-user text-secondary"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            @if($artisan->specialite)
                                <p class="mb-1"><span class="fw-bold">Spécialité:</span> {{ $artisan->specialite }}</p>
                            @endif
                            
                            @if($artisan->experience)
                                <p class="mb-1"><span class="fw-bold">Expérience:</span> {{ $artisan->experience }} ans</p>
                            @endif
                            
                            @if($artisan->telephone)
                                <p class="mb-1"><span class="fw-bold">Téléphone:</span> {{ $artisan->telephone }}</p>
                            @endif
                            
                            @if($artisan->adresse)
                                <p class="mb-0"><span class="fw-bold">Adresse:</span> {{ $artisan->adresse }}, {{ $artisan->code_postal }} {{ $artisan->ville }}</p>
                            @endif
                            
                            <div class="mt-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Modifier mes informations
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Accès rapides -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Accès rapide</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('artisan.tableau-de-bord') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord artisan
                            </a>
                            <a href="{{ route('artisan.produits.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-box me-2"></i> Gérer mes produits
                            </a>
                            <a href="{{ route('artisan.commandes.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-cart me-2"></i> Gérer mes commandes
                            </a>
                            @if($boutique)
                                <a href="{{ route('artisan.boutique.editer') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-store me-2"></i> Gérer ma boutique
                                </a>
                                <a href="{{ route('boutiques.afficher', $boutique) }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-eye me-2"></i> Voir ma boutique
                                </a>
                            @else
                                <a href="{{ route('artisan.boutique.creer') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-store me-2"></i> Créer ma boutique
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    @if(!$boutique)
                        <!-- Pas encore de boutique -->
                        <div class="card mb-4">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-store fa-4x text-muted mb-3"></i>
                                <h4>Créez votre boutique d'artisan</h4>
                                <p class="text-muted mb-4">Vous n'avez pas encore de boutique. Créez votre boutique pour commencer à vendre vos produits.</p>
                                <a href="{{ route('artisan.boutique.creer') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i> Créer ma boutique maintenant
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Informations sur la boutique -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Ma boutique</h5>
                                    <a href="{{ route('artisan.boutique.editer') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i> Modifier
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    @if($boutique->photo)
                                        <img src="{{ asset('storage/' . $boutique->photo) }}" alt="{{ $boutique->nom }}" class="img-thumbnail me-3" style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-light me-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                            <i class="fas fa-store fa-3x text-secondary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="mb-1">{{ $boutique->nom }}</h4>
                                        <p class="text-muted mb-2">Créée le {{ $boutique->created_at->format('d/m/Y') }}</p>
                                        <div class="mb-3">
                                            <span class="badge bg-primary me-1">{{ $totalProduits }} produits</span>
                                            <span class="badge bg-success me-1">{{ $totalCommandes }} commandes</span>
                                            <span class="badge bg-info">{{ $totalAvis ?? 0 }} avis</span>
                                        </div>
                                        <a href="{{ route('boutiques.afficher', $boutique) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-eye me-1"></i> Voir ma boutique
                                        </a>
                                        <a href="{{ route('artisan.tableau-de-bord') }}" class="btn btn-sm btn-primary ms-1">
                                            <i class="fas fa-tachometer-alt me-1"></i> Tableau de bord
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Derniers produits -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Mes derniers produits</h5>
                                    <a href="{{ route('artisan.produits.creer') }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i> Ajouter un produit
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($produits->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="fas fa-box fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Vous n'avez pas encore ajouté de produits à votre boutique.</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Prix</th>
                                                    <th>Stock</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($produits as $produit)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($produit->photo)
                                                                <img src="{{ asset('storage/' . $produit->photo) }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-box text-secondary"></i>
                                                                </div>
                                                            @endif
                                                            <div>{{ $produit->nom }}</div>
                                                        </div>
                                                    </td>
                                                    <td>{{ number_format($produit->prix, 2, ',', ' ') }} MAD</td>
                                                    <td>
                                                        @if($produit->stock > 10)
                                                            <span class="badge bg-success">{{ $produit->stock }}</span>
                                                        @elseif($produit->stock > 0)
                                                            <span class="badge bg-warning text-dark">{{ $produit->stock }}</span>
                                                        @else
                                                            <span class="badge bg-danger">Épuisé</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('artisan.produits.editer', $produit) }}" class="btn btn-outline-primary" title="Modifier">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-outline-secondary" title="Voir">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer bg-light text-end">
                                        <a href="{{ route('artisan.produits.index') }}" class="btn btn-sm btn-link text-muted">Voir tous mes produits <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Derniers avis -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Derniers avis sur mes produits</h5>
                            </div>
                            <div class="card-body p-0">
                                @if(!isset($avis) || $avis->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="fas fa-star fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Aucun avis sur vos produits pour le moment.</p>
                                    </div>
                                @else
                                    <div class="list-group list-group-flush">
                                        @foreach($avis as $avis_item)
                                            <div class="list-group-item p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <strong>{{ $avis_item->user->name }}</strong> a noté 
                                                        <a href="{{ route('produits.afficher', $avis_item->produit) }}">{{ $avis_item->produit->nom }}</a>
                                                    </div>
                                                    <div>
                                                        @for($i = 0; $i < 5; $i++)
                                                            @if($i < $avis_item->note)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-warning"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                                <p class="mb-1 text-muted small">{{ $avis_item->created_at->format('d/m/Y') }}</p>
                                                <p class="mb-0">{{ $avis_item->commentaire }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
