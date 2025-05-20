@extends('layouts.app')

@section('title', 'Detalhes do Módulo - SGB')

@section('content')
    <h2>Detalhes do Módulo: {{ $module->name }}</h2>

    <div style="margin-bottom: 20px; padding:15px; border:1px solid #eee; border-radius:5px;">
        <p><strong>ID:</strong> {{ $module->id }}</p>
        <p><strong>Nome:</strong> {{ $module->name }}</p>
        <p><strong>Sistema Associado:</strong>
            @if($module->system)
                <a href="{{ route('systems.show', $module->system->id) }}">{{ $module->system->name }}</a>
            @else
                N/D (Módulo Global)
            @endif
        </p>
        <p><strong>Criado em:</strong> {{ $module->created_at ? $module->created_at->format('d/m/Y H:i:s') : '-' }}</p>
        <p><strong>Atualizado em:</strong> {{ $module->updated_at ? $module->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
    </div>

    <hr>
    <h3>Tarefas Associadas a este Módulo</h3>
    @if($module->tasks && $module->tasks->count() > 0)
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach($module->tasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                    (Status: {{ $task->status }}) - Prioridade: {{ $task->priority }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Nenhuma tarefa associada a este módulo.</p>
    @endif
    {{-- O link abaixo precisará que a rota 'tasks.create' e o TaskController@create possam lidar com 'module_id' --}}
    <a href="{{ route('tasks.create', ['module_id' => $module->id]) }}" class="btn btn-primary btn-sm" style="margin-top:10px;">Nova Tarefa para este Módulo</a>

    <div style="margin-top: 30px;">
        <a href="{{ route('modules.edit', $module) }}" class="btn btn-warning">Editar Módulo</a>
        @if($module->system)
            <a href="{{ route('modules.index', ['system_id' => $module->system_id]) }}" class="btn btn-secondary">Voltar para Módulos do Sistema</a>
        @else
            <a href="{{ route('modules.index') }}" class="btn btn-secondary">Voltar para Todos os Módulos</a>
        @endif
        <form action="{{ route('modules.destroy', $module) }}" method="POST" style="display:inline; margin-left: 5px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este módulo? As tarefas associadas serão desvinculadas, mas não excluídas.')">Excluir Módulo</button>
        </form>
    </div>

@endsection