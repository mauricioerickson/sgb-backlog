@extends('layouts.app')

@section('title', 'Editar Funcionalidade - SGB')

@section('content')
    <h2>Editar Funcionalidade: {{ $feature->title }}</h2>

    <form action="{{ route('features.update', $feature) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Título da Funcionalidade:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $feature->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="4">{{ old('description', $feature->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="objective_id">Objetivo Principal Associado:</label>
            <select id="objective_id" name="objective_id" required>
                <option value="">Selecione um Objetivo Principal</option>
                @foreach ($mainObjectives as $objective)
                    <option value="{{ $objective->id }}"
                        {{ old('objective_id', $feature->objective_id) == $objective->id ? 'selected' : '' }}>
                        {{ $objective->title }}
                    </option>
                @endforeach
            </select>
            @error('objective_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                @foreach ($statuses as $statusValue)
                    <option value="{{ $statusValue }}" {{ old('status', $feature->status) == $statusValue ? 'selected' : '' }}>
                        {{ $statusValue }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Funcionalidade</button>
        <a href="{{ route('features.show', $feature) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection