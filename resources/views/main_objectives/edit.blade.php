@extends('layouts.app')

@section('title', 'Editar Objetivo Principal - SGB')

@section('content')
    <h2>Editar Objetivo Principal: {{ $mainObjective->title }}</h2>

    <form action="{{ route('main-objectives.update', $mainObjective) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $mainObjective->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $mainObjective->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="quarter_id">Trimestre/Semestre:</label>
            <select id="quarter_id" name="quarter_id">
                <option value="">Selecione um Trimestre/Semestre</option>
                @foreach ($quarters as $quarter)
                    <option value="{{ $quarter->id }}" {{ old('quarter_id', $mainObjective->quarter_id) == $quarter->id ? 'selected' : '' }}>
                        {{ $quarter->name }}
                    </option>
                @endforeach
            </select>
            @error('quarter_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="responsible_user_id">Responsável:</label>
            <select id="responsible_user_id" name="responsible_user_id">
                <option value="">Selecione um Responsável</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('responsible_user_id', $mainObjective->responsible_user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('responsible_user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                @foreach ($statuses as $statusValue) {{-- Renomeado para evitar conflito com a variável $status do objetivo --}}
                    <option value="{{ $statusValue }}" {{ old('status', $mainObjective->status) == $statusValue ? 'selected' : '' }}>
                        {{ $statusValue }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="notes">Notas Adicionais:</label>
            <textarea id="notes" name="notes" rows="3">{{ old('notes', $mainObjective->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('main-objectives.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection