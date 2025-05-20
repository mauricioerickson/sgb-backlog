@extends('layouts.app')

@section('title', 'Detalhes da Sprint - SGB')

@section('content')
    <h2>Detalhes da Sprint: {{ $sprint->name }}</h2>

    <div style="margin-bottom: 20px; padding:15px; border:1px solid #eee; border-radius:5px;">
        <p><strong>ID:</strong> {{ $sprint->id }}</p>
        <p><strong>Nome:</strong> {{ $sprint->name }}</p>
        <p><strong>Data de Início:</strong> {{ $sprint->start_date ? \Carbon\Carbon::parse($sprint->start_date)->format('d/m/Y') : 'N/A' }}</p>
        <p><strong>Data de Fim:</strong> {{ $sprint->end_date ? \Carbon\Carbon::parse($sprint->end_date)->format('d/m/Y') : 'N/A' }}</p>
        <p><strong>Trimestre/Semestre Associado:</strong>
            @if($sprint->quarter)
                <a href="{{ route('quarters.show', $sprint->quarter->id) }}">{{ $sprint->quarter->name }}</a>
            @else
                N/A
            @endif
        </p>
        <p><strong>Criada em:</strong> {{ $sprint->created_at ? $sprint->created_at->format('d/m/Y H:i:s') : '-' }}</p>
        <p><strong>Atualizada em:</strong> {{ $sprint->updated_at ? $sprint->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
    </div>

    <hr>
    <h3>Tarefas com Início nesta Sprint</h3>
    @if($sprint->startTasks && $sprint->startTasks->count() > 0)
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach($sprint->startTasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                    (Status: {{ $task->status }})
                </li>
            @endforeach
        </ul>
    @else
        <p>Nenhuma tarefa programada para iniciar nesta sprint.</p>
    @endif

    <hr style="margin-top: 25px;">
    <h3>Tarefas com Entrega nesta Sprint</h3>
    @if($sprint->deliveryTasks && $sprint->deliveryTasks->count() > 0)
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach($sprint->deliveryTasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                    (Status: {{ $task->status }})
                </li>
            @endforeach
        </ul>
    @else
        <p>Nenhuma tarefa programada para entrega nesta sprint.</p>
    @endif

    {{-- Link para adicionar tarefas a esta sprint (requer lógica no TaskController@create) --}}
    {{-- <a href="{{ route('tasks.create', ['start_sprint_id' => $sprint->id]) }}" class="btn btn-primary btn-sm" style="margin-top:10px;">Nova Tarefa para esta Sprint</a> --}}


    <div style="margin-top: 30px;">
        <a href="{{ route('sprints.edit', $sprint) }}" class="btn btn-warning">Editar Sprint</a>
        @if($sprint->quarter)
            <a href="{{ route('sprints.index', ['quarter_id' => $sprint->quarter_id]) }}" class="btn btn-secondary">Voltar para Sprints do Período</a>
        @else
            <a href="{{ route('sprints.index') }}" class="btn btn-secondary">Voltar para Todas as Sprints</a>
        @endif
        <form action="{{ route('sprints.destroy', $sprint) }}" method="POST" style="display:inline; margin-left: 5px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta sprint? As tarefas associadas serão desvinculadas, mas não excluídas.')">Excluir Sprint</button>
        </form>
    </div>

@endsection