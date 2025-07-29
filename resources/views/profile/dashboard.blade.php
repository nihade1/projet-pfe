@extends('layouts.layout')

@section('title', 'Mon profil')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Bienvenue dans votre espace, {{ $user->name }}</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Informations personnelles</h5>
                            <p class="mb-1"><strong>Nom:</strong> {{ $user->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="mb-4"><strong>Membre depuis:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i> Modifier mes informations
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Tableau de bord</h5>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="feature-box p-3">
                                        <div class="display-4 text-primary">{{ $commandes->count() }}</div>
                                        <p>Commandes</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="feature-box p-3">
                                        <div class="display-4 text-primary">{{ $avis->count() }}</div>
                                        <p>Avis publiés</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="feature-box p-3">
                                        <div class="display-4 text-primary">
                                            {{ $commandes->sum(function($commande) { return $commande->articles->sum('quantite'); }) }}
                                        </div>
                                        <p>Produits achetés</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières commandes -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h5 class="mb-0">Mes dernières commandes</h5>
                    <a href="{{ route('commandes.index') }}" class="btn btn-sm btn-outline-primary">Voir toutes mes commandes</a>
                </div>
                <div class="card-body p-0">
                    @if($commandes->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h5>Vous n'avez pas encore de commandes</h5>
                            <p class="text-muted">Commencez à explorer notre marketplace pour trouver des produits uniques</p>
                            <a href="{{ route('produits.index') }}" class="btn btn-primary mt-2">Découvrir les produits</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Commande</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes->take(5) as $commande)
                                        <tr>
                                            <td>#{{ $commande->id }}</td>
                                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($commande->montant_total, 2, ',', ' ') }} MAD</td>
                                            <td>
                                                @if($commande->statut == 'en_attente')
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @elseif($commande->statut == 'payé')
                                                    <span class="badge bg-success">Payée</span>
                                                @elseif($commande->statut == 'en_preparation')
                                                    <span class="badge bg-info">En préparation</span>
                                                @elseif($commande->statut == 'expediee')
                                                    <span class="badge bg-primary">Expédiée</span>
                                                @elseif($commande->statut == 'livree')
                                                    <span class="badge bg-success">Livrée</span>
                                                @elseif($commande->statut == 'annulee')
                                                    <span class="badge bg-danger">Annulée</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('commandes.afficher', $commande) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers avis -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Mes avis récents</h5>
                </div>
                <div class="card-body">
                    @if($avis->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-comment-alt fa-3x text-muted mb-3"></i>
                            <h5>Vous n'avez pas encore laissé d'avis</h5>
                            <p class="text-muted">Partagez votre expérience avec nos produits et nos artisans</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($avis->take(3) as $avis)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $avis->note)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <small class="text-muted">{{ $avis->created_at->format('d/m/Y') }}</small>
                                            </div>
                                            <h6 class="card-title">
                                                @if($avis->produit)
                                                    <a href="{{ route('produits.afficher', $avis->produit) }}" class="text-decoration-none">
                                                        {{ $avis->produit->nom }}
                                                    </a>
                                                @elseif($avis->boutique)
                                                    <a href="{{ route('boutiques.afficher', $avis->boutique) }}" class="text-decoration-none">
                                                        {{ $avis->boutique->nom }}
                                                    </a>
                                                @endif
                                            </h6>
                                            <p class="card-text small">{{ \Illuminate\Support\Str::limit($avis->commentaire, 100) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
