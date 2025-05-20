@extends('layouts.app')

@section('title', 'Editar Sistema - SGB')

@section('content')
    <h2>Editar Sistema: {{ $system->name }}</h2>

    <form action="{{ route('systems.update', $system) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome do Sistema:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $system->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Sistema</button>
        <a href="{{ route('systems.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection