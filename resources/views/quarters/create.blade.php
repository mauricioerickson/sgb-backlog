@extends('layouts.app')

@section('title', 'Novo Trimestre/Semestre - SGB')

@section('content')
    <h2>Novo Trimestre/Semestre</h2>

    <form action="{{ route('quarters.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Data de Início:</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}">
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">Data de Fim:</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}">
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('quarters.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection