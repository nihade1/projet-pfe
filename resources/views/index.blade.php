@extends('layouts.layout')
@section('title', "Page d'accueil")
@section('content')
    <h1>Bienvenue sur la marketplace artisanale</h1>
    <p>Découvrez des produits uniques, trouvez votre artisan préféré ou créez votre propre boutique !</p>
    <a href="{{ route('produits.index') }}" class="btn btn-primary">Voir les produits</a>
    <a href="{{ route('boutiques.index') }}" class="btn btn-secondary ml-2">Voir les artisans</a>
@endsection
