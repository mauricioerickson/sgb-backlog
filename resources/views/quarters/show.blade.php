@extends('layouts.app')

@section('title', 'Detalhes do Trimestre/Semestre - SGB')

@section('content')
    <h2>Detalhes do Trimestre/Semestre: {{ $quarter->name }}</h2>

    <div style="margin-bottom: 20px;">
        <p><strong>ID:</strong> {{ $quarter->id }}</p>
        <p><strong>Nome:</strong> {{ $quarter->name }}</p>
        <p><strong>Data de Início:</strong> {{ $quarter->start_date ? \Carbon\Carbon::parse($quarter->start_date)->format('d/m/Y') : '-' }}</p>
        <p><strong>Data de Fim:</strong> {{ $quarter->end_date ? \Carbon\Carbon::parse($quarter->end_date)->format('d/m/Y') : '-' }}</p>
        <p><strong>Criado em:</strong> {{ $quarter->created_at ? $quarter->created_at->format('d/m/Y H:i:s') : '-' }}</p>
        <p><strong>Atualizado em:</strong> {{ $quarter->updated_at ? $quarter->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
    </div>

    {{-- Se você quiser listar Objetivos ou Sprints associados a este Quarter aqui, adicione a lógica --}}
    {{-- Exemplo:
    <h3>Objetivos neste Trimestre/Semestre:</h3>
    @if($quarter->mainObjectives->count() > 0)
        <ul>
            @foreach($quarter->mainObjectives as $objective)
                <li>{{ $objective->title }}</li>
            @endforeach
        </ul>
    @else
        <p>Nenhum objetivo principal associado.</p>
    @endif
    --}}

    <a href="{{ route('quarters.edit', $quarter) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('quarters.index') }}" class="btn btn-secondary">Voltar para a Lista</a>
    <form action="{{ route('quarters.destroy', $quarter) }}" method="POST" style="display:inline; margin-left: 5px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este item?')">Excluir</button>
    </form>

@endsection