@extends('layouts.admin')

@section('content')
    
    <h2>Crea un nuovo progetto</h2>

    <form action="{{ route('admin.projects.store') }}" method="POST" encytype="multiparti/form-data">
        @csrf
         
        <div class="mb-3">
            <label for="name" class="form-label"><strong>Nome del progetto</strong></label>
            <input type="text" class="form-control" placeholder="Inserisci un nome" id="name" name="name" value="{{ old('name') }}">
        </div>
        @error('name')
            <div class="alert alert-danger my-2">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="client_name" class="form-label"><strong>Cliente del progetto</strong></label>
            <input type="text" class="form-control" placeholder="Inserisci Nome e Cognome del cliente" id="client_name" name="client_name" value="{{ old('client_name') }}">
        </div>
        @error('client_name')
            <div class="alert alert-danger my-2">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="cover_image" class="form-label">Default file input example</label>
            <input class="form-control" type="file" id="cover_image" name="cover_image">
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label"><strong>Descrizione del progetto</strong></label>
            <textarea class="form-control" rows="6" placeholder="Scrivi una descrizione" id="summary" name="summary" value="{{ old('summary') }}"></textarea>
        </div>
        @error('summary')
            <div class="alert alert-danger my-2">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary">Crea</button>
  </form>
@endsection