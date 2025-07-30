@extends('layouts.layout')

@section('title', 'Tableau de bord - Ma boutique')

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
                    <a href="{{ route('artisan.boutique.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home me-2"></i> Tableau de bord
                    </a>
                    <a href="{{ route('artisan.produits.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-box me-2"></i> Mes produits
                    </a>
                    <a href="{{ route('artisan.commandes.index') }}" class="list-group-item list-group-item-action">
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

            <!-- Informations de la boutique -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex">
                        @if($boutique->photo)
                            <img src="{{ asset('storage/' . $boutique->photo) }}" alt="{{ $boutique->nom }}" class="img-thumbnail me-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light me-3 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                <i class="fas fa-store fa-3x text-secondary"></i>
                            </div>
                        @endif
                        <div>
                            <h1 class="h3 mb-2">{{ $boutique->nom }}</h1>
                            <p class="text-muted mb-3">Créée le {{ $boutique->created_at->format('d/m/Y') }}</p>
                            <a href="{{ route('artisan.boutique.editer') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="{{ route('boutiques.afficher', $boutique) }}" class="btn btn-sm btn-outline-primary ms-2">
                                <i class="fas fa-eye"></i> Voir en tant que client
                            </a>
                            <a href="{{ route('artisan.produits.creer') }}" class="btn btn-sm btn-success ms-2">
                                <i class="fas fa-plus"></i> Ajouter un produit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Produits</h6>
                                    <h2 class="mb-0">{{ $produits->count() }}</h2>
                                </div>
                                <i class="fas fa-box fa-2x opacity-50"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-primary bg-opacity-75 py-1">
                            <a href="{{ route('artisan.produits.index') }}" class="text-white small stretched-link text-decoration-none">Voir tous <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Commandes</h6>
                                    <h2 class="mb-0">{{ $commandes->count() }}</h2>
                                </div>
                                <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-success bg-opacity-75 py-1">
                            <a href="{{ route('artisan.commandes.index') }}" class="text-white small stretched-link text-decoration-none">Voir toutes <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Avis</h6>
                                    <h2 class="mb-0">{{ $nombreAvis }}</h2>
                                </div>
                                <i class="fas fa-star fa-2x opacity-50"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-info bg-opacity-75 py-1">
                            <a href="#" class="text-white small stretched-link text-decoration-none">Voir tous <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm {{ $nombreProduitsAlerte > 0 ? 'bg-danger' : 'bg-warning' }} text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($nombreProduitsAlerte > 0)
                                        <h6 class="mb-0">Alertes Stock</h6>
                                        <h2 class="mb-0">{{ $nombreProduitsAlerte }}</h2>
                                    @else
                                        <h6 class="mb-0">Revenus</h6>
                                        <h2 class="mb-0">{{ number_format($revenuTotal, 2, ',', ' ') }} MAD</h2>
                                    @endif
                                </div>
                                @if($nombreProduitsAlerte > 0)
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                                @else
                                    <i class="fas fa-coins fa-2x opacity-50"></i>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer {{ $nombreProduitsAlerte > 0 ? 'bg-danger' : 'bg-warning' }} bg-opacity-75 py-1">
                            @if($nombreProduitsAlerte > 0)
                                <a href="#alertes-stock" class="text-white small stretched-link text-decoration-none">Voir les produits concernés <i class="fas fa-arrow-right ms-1"></i></a>
                            @else
                                <span class="text-white small">Ventes totales</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alertes de stock -->
            @if($nombreProduitsAlerte > 0)
            <div id="alertes-stock" class="card shadow-sm mb-4 border-danger">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Alertes de stock</h5>
                    <span class="badge bg-light text-danger">{{ $nombreProduitsAlerte }} produit(s)</span>
                </div>
                <div class="card-body">
                    <!-- Produits en rupture de stock -->
                    @if($produitsRuptureStock->count() > 0)
                    <div class="mb-3">
                        <h6 class="text-danger fw-bold"><i class="fas fa-times-circle me-2"></i> Produits en rupture de stock</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produitsRuptureStock as $produit)
                                    <tr class="table-danger">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($produit->photo)
                                                <img src="{{ asset('storage/' . $produit->photo) }}" alt="{{ $produit->nom }}" width="30" height="30" class="img-thumbnail me-2">
                                                @else
                                                <div class="bg-light d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-box text-secondary"></i>
                                                </div>
                                                @endif
                                                <span>{{ $produit->nom }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $produit->prix }} MAD</td>
                                        <td><span class="badge bg-danger">{{ $produit->stock }}</span></td>
                                        <td>
                                            <a href="{{ route('artisan.produits.editer', $produit) }}" class="btn btn-sm btn-danger">
                                                <i class="fas fa-plus me-1"></i> Réapprovisionner
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Produits à stock faible -->
                    @if($produitsStockFaible->count() > 0)
                    <div>
                        <h6 class="text-warning fw-bold"><i class="fas fa-exclamation-circle me-2"></i> Produits à stock faible</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produitsStockFaible as $produit)
                                    <tr class="table-warning">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($produit->photo)
                                                <img src="{{ asset('storage/' . $produit->photo) }}" alt="{{ $produit->nom }}" width="30" height="30" class="img-thumbnail me-2">
                                                @else
                                                <div class="bg-light d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-box text-secondary"></i>
                                                </div>
                                                @endif
                                                <span>{{ $produit->nom }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $produit->prix }} MAD</td>
                                        <td><span class="badge bg-warning text-dark">{{ $produit->stock }}</span></td>
                                        <td>
                                            <a href="{{ route('artisan.produits.editer', $produit) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-plus me-1"></i> Réapprovisionner
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Graphiques statistiques -->
            <div class="row mb-4">
                <div class="col-md-7">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Évolution des revenus</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="revenusChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Commandes par mois</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="commandesChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derniers produits -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Derniers produits</h5>
                    <a href="{{ route('artisan.produits.creer') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un produit
                    </a>
                </div>
                <div class="card-body">
                    @if($produits->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <p class="lead">Vous n'avez pas encore de produits</p>
                            <a href="{{ route('artisan.produits.creer') }}" class="btn btn-primary">
                                Ajouter votre premier produit
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits->take(5) as $produit)
                                        <tr>
                                            <td>
                                                @if($produit->photo)
                                                    <img src="{{ asset('storage/' . $produit->photo) }}" alt="{{ $produit->nom }}" width="40" height="40" class="img-thumbnail">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-box text-secondary"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $produit->nom }}</td>
                                            <td>{{ $produit->prix }} MAD</td>
                                            <td>
                                                @if($produit->stock == 0)
                                                    <span class="badge bg-danger">{{ $produit->stock }}</span>
                                                @elseif($produit->stock <= 5)
                                                    <span class="badge bg-warning text-dark">{{ $produit->stock }}</span>
                                                @else
                                                    {{ $produit->stock }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('artisan.produits.editer', $produit) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-sm btn-outline-primary ms-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($produits->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('artisan.produits.index') }}" class="btn btn-outline-primary btn-sm">Voir tous les produits</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Top produits -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Produits les plus vendus</h5>
                </div>
                <div class="card-body">
                    @if($produits->isEmpty())
                        <div class="text-center py-3">
                            <p class="text-muted">Aucun produit disponible</p>
                        </div>
                    @else
                        <div class="row">
                            @php
                                // Récupérer les produits avec leur nombre de ventes
                                $produitVentes = [];
                                foreach ($produits as $produit) {
                                    $ventes = $produit->articleCommandes()->sum('quantite') ?? 0;
                                    $produitVentes[$produit->id] = [
                                        'produit' => $produit,
                                        'ventes' => $ventes
                                    ];
                                }
                                
                                // Trier par nombre de ventes décroissant
                                uasort($produitVentes, function ($a, $b) {
                                    return $b['ventes'] <=> $a['ventes'];
                                });
                                
                                // Prendre les 3 premiers
                                $topProduits = array_slice($produitVentes, 0, 3);
                            @endphp
                            
                            @foreach($topProduits as $item)
                                @php $produit = $item['produit']; @endphp
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            @if($produit->photo)
                                                <img src="{{ asset('storage/' . $produit->photo) }}" alt="{{ $produit->nom }}" class="img-fluid rounded mb-2" style="height: 120px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded mb-2" style="height: 120px;">
                                                    <i class="fas fa-box fa-3x text-secondary"></i>
                                                </div>
                                            @endif
                                            <h6 class="mb-1">{{ $produit->nom }}</h6>
                                            <p class="text-success fw-bold mb-1">{{ $produit->prix }} MAD</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-primary">{{ $item['ventes'] }} vendus</span>
                                                <span class="badge bg-secondary">Stock: {{ $produit->stock }}</span>
                                            </div>
                                        </div>
                                        <div class="card-footer p-2 bg-light">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('artisan.produits.editer', $produit) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i> Éditer
                                                </a>
                                                <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Dernières commandes -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Dernières commandes</h5>
                </div>
                <div class="card-body">
                    @if($commandes->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="lead">Vous n'avez pas encore reçu de commandes</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes as $commande)
                                        <tr>
                                            <td>#{{ $commande->id }}</td>
                                            <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $commande->user->name }}</td>
                                            <td>{{ $commande->montant_total }} €</td>
                                            <td>
                                                <span class="badge bg-{{ $commande->statut === 'en_attente' ? 'warning' : ($commande->statut === 'expediee' ? 'info' : ($commande->statut === 'livree' ? 'success' : 'secondary')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('artisan.commandes.afficher', $commande) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('artisan.commandes.index') }}" class="btn btn-outline-primary btn-sm">Voir toutes les commandes</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des revenus mensuels
        const revenusCtx = document.getElementById('revenusChart').getContext('2d');
        const revenusChart = new Chart(revenusCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($statsParMois as $mois => $revenu)
                        '{{ $mois }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Revenus mensuels (MAD)',
                    data: [
                        @foreach($statsParMois as $revenu)
                            {{ $revenu }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' MAD';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Graphique des commandes mensuelles
        const commandesCtx = document.getElementById('commandesChart').getContext('2d');
        const commandesChart = new Chart(commandesCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($commandesParMois as $mois => $nombreCommandes)
                        '{{ $mois }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Nombre de commandes',
                    data: [
                        @foreach($commandesParMois as $nombreCommandes)
                            {{ $nombreCommandes }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endsection
@endsection
