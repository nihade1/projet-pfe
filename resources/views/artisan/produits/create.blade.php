@extends('layouts.layout')

@section('title', 'Créer un produit')

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
            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Ajouter un produit</h1>
                <a href="{{ route('artisan.produits.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Retour aux produits
                </a>
            </div>

            <!-- Formulaire de création -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('artisan.produits.enregistrer') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom du produit <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Décrivez votre produit en détail : matériaux, dimensions, processus de fabrication, etc.</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo du produit</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format recommandé: JPG, PNG.</div>
                                </div>
                                
                                <div id="image-preview" class="text-center mt-3" style="display: none;">
                                    <img id="preview" src="#" alt="Aperçu de l'image" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                    <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                                        <option value="">Sélectionnez une catégorie</option>
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                                {{ $categorie->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categorie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="prix" class="form-label">Prix (MAD) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix') }}" step="0.01" min="0" required>
                                        <span class="input-group-text">MAD</span>
                                        @error('prix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock disponible <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 1) }}" min="0" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Enregistrer le produit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Aperçu de l'image avant envoi
    document.getElementById('photo').addEventListener('change', function(e) {
        const imagePreview = document.getElementById('image-preview');
        const preview = document.getElementById('preview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            imagePreview.style.display = 'none';
        }
    });
</script>
@endsection
