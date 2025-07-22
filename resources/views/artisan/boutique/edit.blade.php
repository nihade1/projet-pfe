@extends('layouts.layout')

@section('title', 'Modifier ma boutique')

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
                    <a href="{{ route('artisan.commandes.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart me-2"></i> Commandes
                    </a>
                    <a href="{{ route('artisan.boutique.editer') }}" class="list-group-item list-group-item-action active">
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

            <!-- Formulaire de modification -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Modifier ma boutique</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('artisan.boutique.mettreAJour') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="text-center mb-3">
                                    @if($boutique->photo)
                                        <img src="{{ asset('storage/' . $boutique->photo) }}" alt="{{ $boutique->nom }}" 
                                             class="img-thumbnail mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center mb-2" 
                                             style="width: 150px; height: 150px; margin: 0 auto;">
                                            <i class="fas fa-store fa-3x text-secondary"></i>
                                        </div>
                                    @endif
                                    <div class="form-text mb-2">Photo actuelle</div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Nouvelle photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format recommandé: JPG, PNG.</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom', $boutique->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description de la boutique <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $boutique->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Décrivez votre boutique, vos spécialités, votre histoire, etc.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('artisan.boutique.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
