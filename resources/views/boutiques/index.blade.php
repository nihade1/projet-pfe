@extends('layouts.layout')

@section('title', 'Découvrez nos boutiques d\'artisans')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Découvrez nos boutiques d'artisans</h1>
    
    <p class="lead text-center mb-5">Explorez notre sélection de boutiques tenues par des artisans talentueux et découvrez des créations uniques.</p>
    
    <!-- Recherche -->
    <div class="row mb-5">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('boutiques.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Rechercher une boutique..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- Affichage des boutiques -->
    @if($boutiques->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($boutiques as $boutique)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <!-- Image de la boutique -->
                        @if($boutique->photo)
                            <img src="{{ asset('storage/' . $boutique->photo) }}" class="card-img-top" alt="{{ $boutique->nom }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light text-center p-5">
                                <i class="fas fa-store fa-3x text-secondary"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $boutique->nom }}</h5>
                            
                            <p class="card-text text-muted small">
                                <i class="fas fa-user me-1"></i> {{ $boutique->artisan->user->name }}
                                <span class="mx-2">|</span>
                                <i class="fas fa-box me-1"></i> {{ $boutique->produits->count() }} produits
                            </p>
                            
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($boutique->description, 100) }}</p>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0">
                            <a href="{{ route('boutiques.afficher', $boutique) }}" class="btn btn-outline-primary">
                                Visiter la boutique
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $boutiques->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            @if(request('search'))
                Aucune boutique ne correspond à votre recherche "{{ request('search') }}".
            @else
                Aucune boutique n'est disponible pour le moment. Revenez bientôt !
            @endif
        </div>
    @endif
</div>
@endsection
