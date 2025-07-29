@extends('layouts.layout')

@section('title', 'Détails de la commande')

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
                    <a href="{{ route('artisan.boutique.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-home me-2"></i> Tableau de bord
                    </a>
                    <a href="{{ route('artisan.produits.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-box me-2"></i> Mes produits
                    </a>
                    <a href="{{ route('artisan.commandes.index') }}" class="list-group-item list-group-item-action active">
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

            <!-- En-tête avec actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Commande #{{ $commande->id }}</h1>
                    <p class="text-muted">Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <a href="{{ route('artisan.commandes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Retour aux commandes
                    </a>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Informations client -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Informations client</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nom :</strong> {{ $commande->user->name }}</p>
                            <p><strong>Email :</strong> {{ $commande->user->email }}</p>
                            <p><strong>Téléphone :</strong> {{ $commande->telephone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Adresse de livraison -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Adresse de livraison</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Adresse :</strong> {{ $commande->adresse_livraison }}</p>
                            <p><strong>Code postal :</strong> {{ $commande->code_postal_livraison }}</p>
                            <p><strong>Ville :</strong> {{ $commande->ville_livraison }}</p>
                            <p><strong>Pays :</strong> {{ $commande->pays_livraison }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails de la commande -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Détails de la commande</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Produit</th>
                                    <th scope="col" class="text-center">Quantité</th>
                                    <th scope="col" class="text-end">Prix unitaire</th>
                                    <th scope="col" class="text-end">Total</th>
                                    <th scope="col" class="text-center">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalBoutique = 0; @endphp
                                @foreach($articles as $article)
                                    @php $totalBoutique += $article->prix * $article->quantite; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($article->produit && $article->produit->photo)
                                                    <img src="{{ asset('storage/' . $article->produit->photo) }}" alt="{{ $article->produit->nom }}" 
                                                         class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-box text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">
                                                        @if($article->produit)
                                                            {{ $article->produit->nom }}
                                                        @else
                                                            Produit indisponible
                                                        @endif
                                                    </div>
                                                    <div class="text-muted small">
                                                        Réf: #{{ $article->produit_id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $article->quantite }}</td>
                                        <td class="text-end">{{ number_format($article->prix, 2, ',', ' ') }} €</td>
                                        <td class="text-end">{{ number_format($article->prix * $article->quantite, 2, ',', ' ') }} €</td>
                                        <td class="text-center">
                                            @if($article->statut == 'en_attente')
                                                <span class="badge bg-warning text-dark">En attente</span>
                                            @elseif($article->statut == 'en_preparation')
                                                <span class="badge bg-info">En préparation</span>
                                            @elseif($article->statut == 'expediee')
                                                <span class="badge bg-primary">Expédiée</span>
                                            @elseif($article->statut == 'livree')
                                                <span class="badge bg-success">Livrée</span>
                                            @elseif($article->statut == 'annulee')
                                                <span class="badge bg-danger">Annulée</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total pour votre boutique :</strong></td>
                                    <td class="text-end"><strong>{{ number_format($totalBoutique, 2, ',', ' ') }} €</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total de la commande complète :</strong></td>
                                    <td class="text-end"><strong>{{ number_format($commande->montant_total, 2, ',', ' ') }} €</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mise à jour du statut -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Mettre à jour le statut de la commande</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('artisan.commandes.statut', $commande) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')
                        
                        <div class="col-md-8">
                            <select class="form-select" name="statut">
                                <option value="en_preparation" {{ $articles->first()->statut == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                                <option value="expediee" {{ $articles->first()->statut == 'expediee' ? 'selected' : '' }}>Expédiée</option>
                                <option value="livree" {{ $articles->first()->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                                <option value="annulee" {{ $articles->first()->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                            </select>
                            <div class="form-text">Cette mise à jour s'appliquera à tous les articles de cette commande liés à votre boutique.</div>
                        </div>
                        
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
