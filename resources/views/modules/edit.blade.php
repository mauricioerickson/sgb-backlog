@extends('layouts.app')

@section('title', 'Editar Módulo - SGB')

@section('content')
    <h2>Editar Módulo: {{ $module->name }}</h2>

    <form action="{{ route('modules.update', $module) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome do Módulo:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $module->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="system_id">Sistema Associado (Opcional):</label>
            <select id="system_id" name="system_id">
                <option value="">Nenhum (Módulo Global)</option>
                @foreach ($systems as $system)
                    <option value="{{ $system->id }}"
                        {{ old('system_id', $module->system_id) == $system->id ? 'selected' : '' }}>
                        {{ $system->name }}
                    </option>
                @endforeach
            </select>
            @error('system_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Módulo</button>
        <a href="{{ route('modules.show', $module) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection