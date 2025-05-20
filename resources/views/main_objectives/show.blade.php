@extends('layouts.app')

@section('title', 'Detalhes do Objetivo Principal - SGB')

@section('content')
    <h2>Detalhes do Objetivo: {{ $mainObjective->title }}</h2>

    <div style="margin-bottom: 20px; padding:15px; border:1px solid #eee; border-radius:5px;">
        <p><strong>ID:</strong> {{ $mainObjective->id }}</p>
        <p><strong>Título:</strong> {{ $mainObjective->title }}</p>
        <p><strong>Descrição:</strong> {{ $mainObjective->description ?: 'N/A' }}</p>
        <p><strong>Trimestre/Semestre:</strong> {{ $mainObjective->quarter ? $mainObjective->quarter->name : 'N/A' }}</p>
        <p><strong>Responsável:</strong> {{ $mainObjective->responsibleUser ? $mainObjective->responsibleUser->name : 'N/A' }}</p>
        <p><strong>Status:</strong> {{ $mainObjective->status }}</p>
        <p><strong>Notas Adicionais:</strong> {{ $mainObjective->notes ?: 'N/A' }}</p>
        <p><strong>Criado em:</strong> {{ $mainObjective->created_at ? $mainObjective->created_at->format('d/m/Y H:i:s') : '-' }}</p>
        <p><strong>Atualizado em:</strong> {{ $mainObjective->updated_at ? $mainObjective->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
    </div>

    <hr>
    <h3>Funcionalidades Associadas a este Objetivo</h3>
    @if($mainObjective->features && $mainObjective->features->count() > 0)
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach($mainObjective->features as $feature)
                <li>
                    <a href="{{ route('features.show', $feature->id) }}">{{ $feature->title }}</a> (Status: {{ $feature->status }})
                </li>
            @endforeach
        </ul>
    @else
        <p>Nenhuma funcionalidade associada a este objetivo principal.</p>
    @endif
    <a href="{{ route('features.create', ['objective_id' => $mainObjective->id]) }}" class="btn btn-primary btn-sm" style="margin-top:10px;">Nova Funcionalidade para este Objetivo</a>


    <div style="margin-top: 30px;">
        <a href="{{ route('main-objectives.edit', $mainObjective) }}" class="btn btn-warning">Editar Objetivo</a>
        <a href="{{ route('main-objectives.index') }}" class="btn btn-secondary">Voltar para a Lista</a>
        <form action="{{ route('main-objectives.destroy', $mainObjective) }}" method="POST" style="display:inline; margin-left: 5px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este objetivo? Todas as funcionalidades associadas também serão excluídas.')">Excluir Objetivo</button>
        </form>
    </div>

@endsection