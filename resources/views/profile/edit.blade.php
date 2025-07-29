@extends('layouts.layout')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <a href="{{ route('profile.dashboard') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Retour à mon profil
            </a>
            <h1>Modifier mon profil</h1>
        </div>
    </div>

    <div class="row">
        <!-- Informations personnelles -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informations personnelles</h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->isArtisan())
                        @include('profile.partials.update-artisan-information-form', ['artisan' => auth()->user()->artisan])
                    @else
                        @include('profile.partials.update-profile-information-form')
                    @endif
                </div>
            </div>
        </div>

        <!-- Mot de passe -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Modifier le mot de passe</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Suppression du compte -->
        <div class="col-12 mt-3">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Danger</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
