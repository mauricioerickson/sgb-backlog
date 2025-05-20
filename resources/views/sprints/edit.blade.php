@extends('layouts.app')

@section('title', 'Editar Sprint - SGB')

@section('content')
    <h2>Editar Sprint: {{ $sprint->name }}</h2>

    <form action="{{ route('sprints.update', $sprint) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome da Sprint:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $sprint->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Data de Início (Opcional):</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $sprint->start_date) }}">
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">Data de Fim (Opcional):</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $sprint->end_date) }}">
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="quarter_id">Trimestre/Semestre Associado (Opcional):</label>
            <select id="quarter_id" name="quarter_id">
                <option value="">Nenhum</option>
                @foreach ($quarters as $quarter)
                    <option value="{{ $quarter->id }}"
                        {{ old('quarter_id', $sprint->quarter_id) == $quarter->id ? 'selected' : '' }}>
                        {{ $quarter->name }}
                    </option>
                @endforeach
            </select>
            @error('quarter_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Sprint</button>
        <a href="{{ route('sprints.show', $sprint) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection