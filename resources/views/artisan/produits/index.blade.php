@extends('layouts.layout')

@section('title', 'Mes produits')

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
                    <a href="{{ route('artisan.produits.index') }}" class="list-group-item list-group-item-action active">
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i></strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- En-tête avec actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Mes produits</h1>
                <a href="{{ route('artisan.produits.creer') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Ajouter un produit
                </a>
            </div>

            <!-- Filtres de recherche -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('artisan.produits.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Rechercher</label>
                            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nom du produit...">
                        </div>
                        <div class="col-md-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <select class="form-select" id="categorie" name="categorie">
                                <option value="">Toutes</option>
                                @foreach(\App\Models\Categorie::all() as $categorie)
                                    <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="stock" class="form-label">Stock</label>
                            <select class="form-select" id="stock" name="stock">
                                <option value="">Tous</option>
                                <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Stock bas (≤ 5)</option>
                                <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Épuisé</option>
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

            <!-- Liste des produits -->
            @if($produits->isEmpty())
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <h3 class="h5">Aucun produit trouvé</h3>
                        <p class="text-muted">Vous n'avez pas encore de produits dans votre boutique.</p>
                        <a href="{{ route('artisan.produits.creer') }}" class="btn btn-primary">
                            Ajouter votre premier produit
                        </a>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Produit</th>
                                        <th scope="col">Catégorie</th>
                                        <th scope="col" class="text-end">Prix</th>
                                        <th scope="col" class="text-center">Stock</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits as $produit)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        @if($produit->photo)
                                                            <img src="{{ asset('storage/' . $produit->photo) }}" alt="{{ $produit->nom }}" 
                                                                 class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="fas fa-box text-secondary"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $produit->nom }}</div>
                                                        <div class="text-muted small">Ajouté le {{ $produit->created_at->format('d/m/Y') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $produit->categorie->nom }}</td>
                                            <td class="text-end">{{ number_format($produit->prix, 2, ',', ' ') }} MAD</td>
                                            <td class="text-center">
                                                @if($produit->stock <= 0)
                                                    <span class="badge bg-danger">Épuisé</span>
                                                @elseif($produit->stock <= 5)
                                                    <span class="badge bg-warning text-dark">{{ $produit->stock }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ $produit->stock }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('artisan.produits.editer', $produit) }}" class="btn btn-sm btn-outline-primary me-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-sm btn-outline-secondary me-2" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('artisan.produits.supprimer', $produit) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
