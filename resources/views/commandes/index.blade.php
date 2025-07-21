@extends('layouts.layout')

@section('title', 'Mes commandes')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Mes commandes</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($commandes->count() > 0)
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>N° Commande</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td class="align-middle">#{{ $commande->id }}</td>
                                    <td class="align-middle">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="align-middle">
                                        <span class="badge bg-{{ $commande->statut === 'livree' ? 'success' : ($commande->statut === 'en_cours' ? 'warning' : 'primary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ number_format($commande->montant_total, 2) }} €</td>
                                    <td class="align-middle">
                                        <a href="{{ route('commandes.afficher', $commande) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                <h3 class="mb-3">Aucune commande</h3>
                <p class="mb-4">Vous n'avez pas encore passé de commande.</p>
                <a href="{{ route('produits.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i> Découvrir nos produits
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
@endsection
