@extends('layouts.admin')

@section('content')
     
    <h2>Modifica progetto: {{ $project->name }}</h2>
    
    <form action="{{ route('admin.projects.update', ['project'=> $project->slug]) }}" method="POST" encytype="multiparti/form-data">
        @csrf
        @method('PUT')
     
        <div class="mb-3">
            <label for="name" class="form-label"><strong>Nuovo nome del progetto</strong></label>
            <input type="text" class="form-control" placeholder="Inserisci un nome" id="name" name="name" value="{{ old('name', $project->name) }}">
        </div>
        @error('name')
            <div class="alert alert-danger my-2">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="client_name" class="form-label"><strong>Nuovo cliente del progetto</strong></label>
            <input type="text" class="form-control" placeholder="Inserisci Nome e Cognome del cliente" id="client_name" name="client_name" value="{{ old('client_name', $project->client_name) }}">
        </div>
        @error('client_name')
            <div class="alert alert-danger my-2">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="cover_image" class="form-label">Default file input example</label>
            <input class="form-control" type="file" id="cover_image" name="cover_image">
            @if($project->cover_image)
                <div>
                    <img width="150" src="{{ asset('storage/' , $project->cover_image) }}" alt="{{ $project->name }}">
                </div>                
            @else
                <small>Nessuna immagine disponibile</small>                
            @endif
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label"><strong>Descrizione del progetto</strong></label>
            <textarea class="form-control" rows="6" placeholder="Scrivi una descrizione" id="summary" name="summary" value="{{ old('summary', $project->summary) }}"></textarea>
        </div>
        @error('summary')
            <div class="alert alert-danger my-2">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-success">Modifica</button>
    </form>
@endsection