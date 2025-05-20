@extends('layouts.app')

@section('title', 'Nova Funcionalidade - SGB')

@section('content')
    <h2>Nova Funcionalidade</h2>

    <form action="{{ route('features.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Título da Funcionalidade:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
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
                        {{ old('objective_id', $selectedObjectiveId ?? '') == $objective->id ? 'selected' : '' }}>
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
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salvar Funcionalidade</button>
        @if(isset($selectedObjectiveId) && $selectedObjectiveId)
            <a href="{{ route('main-objectives.show', $selectedObjectiveId) }}" class="btn btn-secondary">Cancelar</a>
        @else
            <a href="{{ route('features.index') }}" class="btn btn-secondary">Cancelar</a>
        @endif
    </form>
@endsection