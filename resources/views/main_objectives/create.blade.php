@extends('layouts.app')

@section('title', 'Novo Objetivo Principal - SGB')

@section('content')
    <h2>Novo Objetivo Principal</h2>

    <form action="{{ route('main-objectives.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="quarter_id">Trimestre/Semestre:</label>
            <select id="quarter_id" name="quarter_id">
                <option value="">Selecione um Trimestre/Semestre</option>
                @foreach ($quarters as $quarter)
                    <option value="{{ $quarter->id }}" {{ old('quarter_id') == $quarter->id ? 'selected' : '' }}>
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
                    <option value="{{ $user->id }}" {{ old('responsible_user_id') == $user->id ? 'selected' : '' }}>
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

        <div class="form-group">
            <label for="notes">Notas Adicionais:</label>
            <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('main-objectives.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection