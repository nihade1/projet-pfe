@extends('layouts.layout')

@section('title', 'Paiement de la commande')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Finaliser votre commande</h1>
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <!-- Formulaire de livraison -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Adresse de livraison</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('commandes.enregistrer') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="adresse_livraison" class="form-label">Adresse*</label>
                                <input type="text" class="form-control @error('adresse_livraison') is-invalid @enderror" 
                                       id="adresse_livraison" name="adresse_livraison" value="{{ old('adresse_livraison') }}" required>
                                @error('adresse_livraison')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="code_postal_livraison" class="form-label">Code postal*</label>
                                <input type="text" class="form-control @error('code_postal_livraison') is-invalid @enderror" 
                                       id="code_postal_livraison" name="code_postal_livraison" value="{{ old('code_postal_livraison') }}" required>
                                @error('code_postal_livraison')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label for="ville_livraison" class="form-label">Ville*</label>
                                <input type="text" class="form-control @error('ville_livraison') is-invalid @enderror" 
                                       id="ville_livraison" name="ville_livraison" value="{{ old('ville_livraison') }}" required>
                                @error('ville_livraison')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pays_livraison" class="form-label">Pays*</label>
                                <input type="text" class="form-control @error('pays_livraison') is-invalid @enderror" 
                                       id="pays_livraison" name="pays_livraison" value="{{ old('pays_livraison', 'Maroc') }}" required>
                                @error('pays_livraison')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" name="telephone" value="{{ old('telephone') }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="card mt-4 mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Informations de paiement</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <h6 class="mb-0">Carte bancaire</h6>
                                        <div class="d-flex gap-2 ms-3">
                                            <i class="fab fa-cc-visa fa-lg text-primary"></i>
                                            <i class="fab fa-cc-mastercard fa-lg text-danger"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="ps-0">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="nom_carte" class="form-label">Nom sur la carte*</label>
                                                <input type="text" class="form-control @error('nom_carte') is-invalid @enderror" 
                                                       id="nom_carte" name="nom_carte" value="{{ old('nom_carte') }}" 
                                                       pattern="[A-Za-z\s]+" title="Le nom doit contenir uniquement des lettres et des espaces" required>
                                                @error('nom_carte')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Entrez le nom tel qu'il apparaît sur votre carte</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="numero_carte" class="form-label">Numéro de carte*</label>
                                                <input type="text" class="form-control @error('numero_carte') is-invalid @enderror" 
                                                       id="numero_carte" name="numero_carte" value="{{ old('numero_carte') }}" 
                                                       placeholder="1234 5678 9012 3456" 
                                                       pattern="[0-9\s]{13,19}" title="Le numéro de carte doit contenir entre 13 et 19 chiffres" 
                                                       maxlength="19" required>
                                                @error('numero_carte')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Format: XXXX XXXX XXXX XXXX</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="expiration" class="form-label">Date d'expiration*</label>
                                                <input type="text" class="form-control @error('expiration') is-invalid @enderror" 
                                                       id="expiration" name="expiration" value="{{ old('expiration') }}" 
                                                       placeholder="MM/AA" pattern="(0[1-9]|1[0-2])\/([0-9]{2})" 
                                                       title="Format requis: MM/AA (par exemple 05/28)" maxlength="5" required>
                                                @error('expiration')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Format: MM/AA</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cvv" class="form-label">CVV*</label>
                                                <input type="text" class="form-control @error('cvv') is-invalid @enderror" 
                                                       id="cvv" name="cvv" value="{{ old('cvv') }}" 
                                                       placeholder="123" pattern="[0-9]{3,4}" 
                                                       title="Le CVV doit contenir 3 ou 4 chiffres" maxlength="4" required>
                                                @error('cvv')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">3 ou 4 chiffres au dos de votre carte</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-lock me-2"></i> Confirmer le paiement
                            </button>
                            <a href="{{ route('panier.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Retour au panier
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Récapitulatif de la commande -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Récapitulatif</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($produits as $produit)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="my-0">{{ $produit->nom }}</h6>
                                    <small class="text-muted">{{ $panier[$produit->id] }} x {{ number_format($produit->prix, 2) }} MAD</small>
                                </div>
                                <span>{{ number_format($produit->prix * $panier[$produit->id], 2) }} MAD</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total:</span>
                        <span>{{ number_format($total, 2) }} MAD</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Frais de livraison:</span>
                        <span>{{ number_format(0, 2) }} MAD</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4 fw-bold">
                        <span>Total:</span>
                        <span>{{ number_format($total, 2) }} MAD</span>
                    </div>
                    
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i> En validant votre commande, vous acceptez nos conditions générales de vente.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formatage automatique du numéro de carte
    const numeroCarteInput = document.getElementById('numero_carte');
    numeroCarteInput.addEventListener('input', function(e) {
        // Supprimer tous les espaces
        let value = e.target.value.replace(/\s+/g, '');
        // Ajouter un espace tous les 4 caractères
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        // Mettre à jour la valeur du champ
        e.target.value = value;
    });
    
    // Formatage automatique de la date d'expiration
    const expirationInput = document.getElementById('expiration');
    expirationInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Garder uniquement les chiffres
        
        if (value.length >= 2) {
            // Ajouter un / après les 2 premiers chiffres
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        
        // Mettre à jour la valeur du champ
        e.target.value = value;
    });
    
    // Limiter le CVV à des chiffres uniquement
    const cvvInput = document.getElementById('cvv');
    cvvInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
    
    // Validation du nom sur la carte (lettres et espaces uniquement)
    const nomCarteInput = document.getElementById('nom_carte');
    nomCarteInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^A-Za-z\s]/g, '');
    });
    
    // Validation du formulaire avant soumission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        // Vérifier le numéro de carte
        const numeroCarteValue = numeroCarteInput.value.replace(/\s+/g, '');
        if (numeroCarteValue.length < 13 || numeroCarteValue.length > 19) {
            alert('Le numéro de carte doit contenir entre 13 et 19 chiffres.');
            e.preventDefault();
            return false;
        }
        
        // Vérifier la date d'expiration
        const expirationValue = expirationInput.value;
        if (!/^(0[1-9]|1[0-2])\/[0-9]{2}$/.test(expirationValue)) {
            alert('La date d\'expiration doit être au format MM/AA.');
            e.preventDefault();
            return false;
        }
        
        // Vérifier l'année d'expiration (pas dans le passé)
        const [month, year] = expirationValue.split('/');
        const expDate = new Date(2000 + parseInt(year), parseInt(month) - 1);
        const now = new Date();
        if (expDate < now) {
            alert('La date d\'expiration est déjà passée.');
            e.preventDefault();
            return false;
        }
        
        // Vérifier le CVV
        const cvvValue = cvvInput.value;
        if (cvvValue.length < 3 || cvvValue.length > 4) {
            alert('Le CVV doit contenir 3 ou 4 chiffres.');
            e.preventDefault();
            return false;
        }
        
        return true;
    });
});
</script>
@endpush
@endsection
