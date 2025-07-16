@extends('layouts.layout')

@section('title', 'Créer votre boutique')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Créez votre boutique d'artisan</h1>
                </div>
                <div class="card-body">
                    <p class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Bienvenue ! Pour commencer à vendre vos produits, veuillez créer votre boutique.
                    </p>

                    <form method="POST" action="{{ route('artisan.boutique.enregistrer') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description de la boutique <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Décrivez votre boutique, vos spécialités, votre histoire, etc.</div>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo de la boutique</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format recommandé: JPG, PNG. Taille maximale: 2 MB.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Créer ma boutique</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
