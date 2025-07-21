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
                                       id="pays_livraison" name="pays_livraison" value="{{ old('pays_livraison', 'France') }}" required>
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
                                <h5 class="mb-0">Méthode de paiement</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="methode_paiement" id="carte" value="carte" checked>
                                    <label class="form-check-label" for="carte">
                                        <div class="d-flex align-items-center">
                                            <span class="me-3">Carte bancaire</span>
                                            <div class="d-flex gap-2">
                                                <i class="fab fa-cc-visa fa-lg text-primary"></i>
                                                <i class="fab fa-cc-mastercard fa-lg text-danger"></i>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div id="carte_details" class="mb-4 ps-4">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="nom_carte" class="form-label">Nom sur la carte</label>
                                            <input type="text" class="form-control" id="nom_carte">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="numero_carte" class="form-label">Numéro de carte</label>
                                            <input type="text" class="form-control" id="numero_carte" placeholder="1234 5678 9012 3456">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="expiration" class="form-label">Date d'expiration</label>
                                            <input type="text" class="form-control" id="expiration" placeholder="MM/AA">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cvv" placeholder="123">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="methode_paiement" id="paypal" value="paypal">
                                    <label class="form-check-label" for="paypal">
                                        <div class="d-flex align-items-center">
                                            <span class="me-3">PayPal</span>
                                            <i class="fab fa-paypal fa-lg text-info"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-lock me-2"></i> Passer la commande
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
                                    <small class="text-muted">{{ $panier[$produit->id] }} x {{ number_format($produit->prix, 2) }} €</small>
                                </div>
                                <span>{{ number_format($produit->prix * $panier[$produit->id], 2) }} €</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total:</span>
                        <span>{{ number_format($total, 2) }} €</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Frais de livraison:</span>
                        <span>{{ number_format(0, 2) }} €</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4 fw-bold">
                        <span>Total:</span>
                        <span>{{ number_format($total, 2) }} €</span>
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
    const radioCarte = document.getElementById('carte');
    const radioPaypal = document.getElementById('paypal');
    const carteDetails = document.getElementById('carte_details');
    
    radioPaypal.addEventListener('change', function() {
        if(this.checked) {
            carteDetails.style.display = 'none';
        }
    });
    
    radioCarte.addEventListener('change', function() {
        if(this.checked) {
            carteDetails.style.display = 'block';
        }
    });
});
</script>
@endpush
@endsection
