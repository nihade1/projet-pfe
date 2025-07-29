@extends('layouts.layout')

@section('title', 'Commandes reçues')

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

            <!-- En-tête -->
            <div class="mb-4">
                <h1 class="h3">Commandes reçues</h1>
                <p class="text-muted">Gérez les commandes que vous avez reçues pour vos produits.</p>
            </div>

            <!-- Filtres de recherche -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('artisan.commandes.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Rechercher</label>
                            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="N° de commande ou client...">
                        </div>
                        <div class="col-md-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select class="form-select" id="statut" name="statut">
                                <option value="">Tous</option>
                                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="en_preparation" {{ request('statut') == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                                <option value="expediee" {{ request('statut') == 'expediee' ? 'selected' : '' }}>Expédiée</option>
                                <option value="livree" {{ request('statut') == 'livree' ? 'selected' : '' }}>Livrée</option>
                                <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label">Période</label>
                            <select class="form-select" id="date" name="date">
                                <option value="">Toutes les dates</option>
                                <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                                <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                                <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Ce mois</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search me-1"></i> Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Liste des commandes -->
            @if($commandes->isEmpty())
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h3 class="h5">Aucune commande trouvée</h3>
                        <p class="text-muted">Vous n'avez pas encore reçu de commandes pour vos produits.</p>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">N° Commande</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Client</th>
                                        <th scope="col" class="text-end">Montant</th>
                                        <th scope="col" class="text-center">Statut du paiement</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes as $commande)
                                        <tr>
                                            <td>#{{ $commande->id }}</td>
                                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $commande->user->name }}</td>
                                            <td class="text-end">
                                                {{ number_format($commande->montant_boutique, 2, ',', ' ') }} €
                                            </td>
                                            <td class="text-center">
                                                @if($commande->statut == 'payé')
                                                    <span class="badge bg-success">Payée</span>
                                                @elseif($commande->statut_boutique == 'en_attente')
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @elseif($commande->statut_boutique == 'en_preparation')
                                                    <span class="badge bg-info">En préparation</span>
                                                @elseif($commande->statut_boutique == 'expediee')
                                                    <span class="badge bg-primary">Expédiée</span>
                                                @elseif($commande->statut_boutique == 'livree')
                                                    <span class="badge bg-success">Livrée</span>
                                                @elseif($commande->statut_boutique == 'annulee')
                                                    <span class="badge bg-danger">Annulée</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('artisan.commandes.afficher', $commande) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $commandes->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
