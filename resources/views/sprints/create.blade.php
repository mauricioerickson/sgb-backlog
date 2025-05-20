@extends('layouts.app')

@section('title', 'Nova Sprint - SGB')

@section('content')
    <h2>Nova Sprint</h2>

    <form action="{{ route('sprints.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome da Sprint:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Data de Início (Opcional):</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}">
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">Data de Fim (Opcional):</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}">
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
                        {{ old('quarter_id', $selectedQuarterId ?? '') == $quarter->id ? 'selected' : '' }}>
                        {{ $quarter->name }}
                    </option>
                @endforeach
            </select>
            @error('quarter_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salvar Sprint</button>
        @if(isset($selectedQuarterId) && $selectedQuarterId)
            <a href="{{ route('quarters.show', $selectedQuarterId) }}" class="btn btn-secondary">Cancelar</a>
        @else
            <a href="{{ route('sprints.index') }}" class="btn btn-secondary">Cancelar</a>
        @endif
    </form>
@endsection