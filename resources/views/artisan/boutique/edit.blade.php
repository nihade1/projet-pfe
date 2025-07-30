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
                        </div>

                        <div class="mb-3">
                            <label for="slogan" class="form-label">Slogan de la boutique</label>
                            <input type="text" class="form-control @error('slogan') is-invalid @enderror" 
                                   id="slogan" name="slogan" value="{{ old('slogan', $boutique->slogan) }}">
                            @error('slogan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Une phrase courte qui résume l'esprit de votre boutique</div>
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse physique (optionnelle)</label>
                            <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                                   id="adresse" name="adresse" value="{{ old('adresse', $boutique->adresse) }}">
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Si vous avez un atelier ou une boutique physique</div>
                        </div>
                        
                        <hr class="my-4">
                        <h5 class="mb-3">Personnalisation visuelle</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="couleur_fond" class="form-label">Couleur de fond</label>
                                <input type="color" class="form-control form-control-color" id="couleur_fond" name="couleur_fond" 
                                       value="{{ old('couleur_fond', $boutique->couleur_fond ?? '#ffffff') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="couleur_texte" class="form-label">Couleur du texte</label>
                                <input type="color" class="form-control form-control-color" id="couleur_texte" name="couleur_texte" 
                                       value="{{ old('couleur_texte', $boutique->couleur_texte ?? '#333333') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="couleur_accent" class="form-label">Couleur d'accentuation</label>
                                <input type="color" class="form-control form-control-color" id="couleur_accent" name="couleur_accent" 
                                       value="{{ old('couleur_accent', $boutique->couleur_accent ?? '#007A75') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="police" class="form-label">Police</label>
                                <select class="form-select" id="police" name="police">
                                    <option value="Roboto" {{ (old('police', $boutique->police) == 'Roboto' || !$boutique->police) ? 'selected' : '' }}>Roboto (moderne)</option>
                                    <option value="Open Sans" {{ (old('police', $boutique->police) == 'Open Sans') ? 'selected' : '' }}>Open Sans (lisible)</option>
                                    <option value="Montserrat" {{ (old('police', $boutique->police) == 'Montserrat') ? 'selected' : '' }}>Montserrat (élégante)</option>
                                    <option value="Raleway" {{ (old('police', $boutique->police) == 'Raleway') ? 'selected' : '' }}>Raleway (légère)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-text mb-3">Ces paramètres permettent de personnaliser l'apparence de votre boutique pour les visiteurs.</div>
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
