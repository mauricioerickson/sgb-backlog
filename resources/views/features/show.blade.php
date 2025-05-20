@extends('layouts.app')

@section('title', 'Detalhes da Funcionalidade - SGB')

@section('content')
    <h2>Detalhes da Funcionalidade: {{ $feature->title }}</h2>

    <div style="margin-bottom: 20px; padding:15px; border:1px solid #eee; border-radius:5px;">
        <p><strong>ID:</strong> {{ $feature->id }}</p>
        <p><strong>Título:</strong> {{ $feature->title }}</p>
        <p><strong>Descrição:</strong> {{ $feature->description ?: 'N/A' }}</p>
        <p><strong>Objetivo Principal:</strong>
            @if($feature->mainObjective)
                <a href="{{ route('main-objectives.show', $feature->mainObjective->id) }}">{{ $feature->mainObjective->title }}</a>
            @else
                N/A
            @endif
        </p>
        <p><strong>Status:</strong> {{ $feature->status }}</p>
        <p><strong>Criada em:</strong> {{ $feature->created_at ? $feature->created_at->format('d/m/Y H:i:s') : '-' }}</p>
        <p><strong>Atualizada em:</strong> {{ $feature->updated_at ? $feature->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
    </div>

    <hr>
    <h3>Tarefas Associadas a esta Funcionalidade</h3>
    @if($feature->tasks && $feature->tasks->count() > 0)
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach($feature->tasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a> (Status: {{ $task->status }})
                     - Prioridade: {{ $task->priority }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Nenhuma tarefa associada a esta funcionalidade.</p>
    @endif
    {{-- O link abaixo precisará que a rota 'tasks.create' e o TaskController@create possam lidar com 'feature_id' --}}
    <a href="{{ route('tasks.create', ['feature_id' => $feature->id]) }}" class="btn btn-primary btn-sm" style="margin-top:10px;">Nova Tarefa para esta Funcionalidade</a>


    <div style="margin-top: 30px;">
        <a href="{{ route('features.edit', $feature) }}" class="btn btn-warning">Editar Funcionalidade</a>
        @if($feature->mainObjective)
            <a href="{{ route('features.index', ['objective_id' => $feature->mainObjective->id]) }}" class="btn btn-secondary">Voltar para Funcionalidades do Objetivo</a>
        @else
            <a href="{{ route('features.index') }}" class="btn btn-secondary">Voltar para Todas as Funcionalidades</a>
        @endif
        <form action="{{ route('features.destroy', $feature) }}" method="POST" style="display:inline; margin-left: 5px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta funcionalidade? Todas as tarefas associadas também serão excluídas.')">Excluir Funcionalidade</button>
        </form>
    </div>

@endsection