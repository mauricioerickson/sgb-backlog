@extends('layouts.app')

@section('title', 'Novo Sistema - SGB')

@section('content')
    <h2>Novo Sistema</h2>

    <form action="{{ route('systems.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome do Sistema:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salvar Sistema</button>
        <a href="{{ route('systems.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection