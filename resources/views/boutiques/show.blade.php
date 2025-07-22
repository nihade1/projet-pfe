@extends('layouts.layout')

@section('title', $boutique->nom)

@section('content')
<div class="container py-5">
    <!-- En-tête de la boutique -->
    <div class="row mb-5">
        <div class="col-md-4">
            @if($boutique->photo)
                <img src="{{ asset('storage/' . $boutique->photo) }}" alt="{{ $boutique->nom }}" class="img-fluid rounded shadow-sm">
            @else
                <div class="bg-light text-center py-5 rounded shadow-sm">
                    <i class="fas fa-store fa-5x text-secondary"></i>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <h1>{{ $boutique->nom }}</h1>
            
            <div class="d-flex align-items-center mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($boutique->artisan->user->name) }}&background=random" 
                     alt="{{ $boutique->artisan->user->name }}" 
                     class="rounded-circle me-2" 
                     width="40">
                <span>Par <strong>{{ $boutique->artisan->user->name }}</strong></span>
            </div>
            
            <div class="mb-3">
                @if($avis && $avis->count() > 0)
                    @php
                        $moyenne = $avis->avg('note');
                        $nbAvis = $avis->count();
                    @endphp
                    <div class="d-flex align-items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($moyenne) ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <span class="ms-2">{{ number_format($moyenne, 1) }}/5 ({{ $nbAvis }} avis)</span>
                    </div>
                @else
                    <div class="text-muted">
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <i class="fas fa-star text-muted"></i>
                        <span class="ms-2">Aucun avis pour le moment</span>
                    </div>
                @endif
            </div>
            
            <p class="lead">{{ $boutique->description }}</p>
        </div>
    </div>

    <!-- Onglets -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" id="products-tab" data-bs-toggle="tab" href="#products" role="tab">Produits</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab">Avis</a>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content">
        <!-- Produits -->
        <div class="tab-pane fade show active" id="products" role="tabpanel">
            @if($boutique->produits->count() > 0)
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($boutique->produits as $produit)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                @if($produit->photo)
                                    <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top" alt="{{ $produit->nom }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light text-center p-5">
                                        <i class="fas fa-box fa-3x text-secondary"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produit->nom }}</h5>
                                    <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($produit->description, 80) }}</p>
                                    <p class="card-text fw-bold">{{ number_format($produit->prix, 2) }} MAD</p>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <a href="{{ route('produits.afficher', $produit) }}" class="btn btn-sm btn-outline-primary">Voir détails</a>
                                    @auth
                                        <form method="POST" action="{{ route('panier.ajouter') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                            <input type="hidden" name="quantite" value="1">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-success" title="Connectez-vous pour ajouter au panier">
                                            <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    Cette boutique n'a pas encore de produits.
                </div>
            @endif
        </div>

        <!-- Avis -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            @if($avis && $avis->count() > 0)
                <div class="list-group mb-4">
                    @foreach($avis as $avisItem)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $avisItem->user->name }}</strong>
                                    <span class="text-muted ms-2">{{ $avisItem->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $avisItem->note ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($avisItem->commentaire)
                                <p class="mt-2 mb-0">{{ $avisItem->commentaire }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info mb-4">
                    Cette boutique n'a pas encore reçu d'avis.
                </div>
            @endif

            <!-- Formulaire d'ajout d'avis -->
            @auth
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Laisser un avis</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('boutiques.avis', $boutique) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Note</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="note" id="note1" value="1" required>
                                        <label class="form-check-label" for="note1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="note" id="note2" value="2">
                                        <label class="form-check-label" for="note2">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="note" id="note3" value="3">
                                        <label class="form-check-label" for="note3">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="note" id="note4" value="4">
                                        <label class="form-check-label" for="note4">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="note" id="note5" value="5">
                                        <label class="form-check-label" for="note5">5</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                                <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer mon avis</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un avis sur cette boutique.
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
