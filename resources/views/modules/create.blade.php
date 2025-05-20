@extends('layouts.app')

@section('title', 'Novo Módulo - SGB')

@section('content')
    <h2>Novo Módulo</h2>

    <form action="{{ route('modules.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome do Módulo:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
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
                        {{ old('system_id', $selectedSystemId ?? '') == $system->id ? 'selected' : '' }}>
                        {{ $system->name }}
                    </option>
                @endforeach
            </select>
            @error('system_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salvar Módulo</button>
        @if(isset($selectedSystemId) && $selectedSystemId)
            <a href="{{ route('systems.show', $selectedSystemId) }}" class="btn btn-secondary">Cancelar</a>
        @else
            <a href="{{ route('modules.index') }}" class="btn btn-secondary">Cancelar</a>
        @endif
    </form>
@endsection