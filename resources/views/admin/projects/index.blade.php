@extends('layouts.admin')

@section('content')
    {{-- @include('partials.flash-messages') --}}

    <h2>Lista Progetti</h2>

    <table class="table table-sm table-striped fs-6 border mt-3">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Cliente</th>
            <th scope="col">Data creazione</th>
            <th scope="col">Ultimo aggiornamento</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
          @foreach($projects as $project)
          <tr>
            <td>{{ $project->id }}</td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->client_name }}</td>
            <td>{{ $project->created_at }}</td>
            <td>{{ $project->updated_at }}</td>
            <td>
                <div>
                  <a href="{{ route('admin.projects.show', ['project'=> $project->slug]) }}" type="button" class="btn btn-primary ms-btn p-1 badge text-center">Mostra</a>
                </div>
                <div>
                  <a href="{{ route('admin.projects.edit', ['project'=> $project->slug]) }}" type="button" class="btn btn-success ms-btn ms-fs-small badge text-center">Modifica</a>
                </div>
                <div>
                  <form action="{{ route('admin.projects.destroy', ['project'=> $project->slug]) }}" method="POST">
                  @csrf
                  @method('DELETE')
                    <button type="submit" class="btn btn-danger ms-btn p-1 badge text-center">Elimina</button>
                  </form>
                </div>
            </td>
          </tr>              
          @endforeach  
        </tbody>
      </table>
@endsection