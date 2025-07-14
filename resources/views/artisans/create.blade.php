@extends('layouts.layout')
@section('title', 'Créer une boutique artisanale')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Créer ma boutique</h2>
        <form method="POST" action="{{ route('artisan.boutique.enregistrer') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-2">
                <label for="nom">Nom de la boutique</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group mb-2">
                <label for="photo">Photo de la boutique</label>
                <input type="file" name="photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-success w-100">Créer la boutique</button>
        </form>
    </div>
</div>
@endsection
