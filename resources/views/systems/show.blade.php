@extends('layouts.app')

@section('title', 'Detalhes do Sistema - SGB')

@section('content')
    <h2>Detalhes do Sistema: {{ $system->name }}</h2>

    <div style="margin-bottom: 20px; padding:15px; border:1px solid #eee; border-radius:5px;">
        <p><strong>ID:</strong> {{ $system->id }}</p>
        <p><strong>Nome:</strong> {{ $system->name }}</p>
        <p><strong>Criado em:</strong> {{ $system->created_at ? $system->created_at->format('d/m/Y H:i:s') : '-' }}</p>
        <p><strong>Atualizado em:</strong> {{ $system->updated_at ? $system->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
    </div>

    <hr>
    <h3>Módulos Associados a este Sistema</h3>
    @if($system->modules && $system->modules->count() > 0)
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach($system->modules as $module)
                <li>
                    {{-- Assumindo que você terá uma rota para modules.show --}}
                    <a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Nenhum módulo associado a este sistema.</p>
    @endif
    {{-- Link para criar novo módulo associado (requer lógica no ModuleController@create) --}}
    {{-- <a href="{{ route('modules.create', ['system_id' => $system->id]) }}" class="btn btn-primary btn-sm" style="margin-top:10px;">Novo Módulo para este Sistema</a> --}}

    <hr style="margin-top: 25px;">
    <h3>Tarefas Associadas a este Sistema</h3>
    @if($system->tasks && $system->tasks->count() > 0)
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach($system->tasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                    (Status: {{ $task->status }})
                </li>
            @endforeach
        </ul>
    @else
        <p>Nenhuma tarefa diretamente associada a este sistema (as tarefas podem estar associadas via módulos deste sistema).</p>
    @endif


    <div style="margin-top: 30px;">
        <a href="{{ route('systems.edit', $system) }}" class="btn btn-warning">Editar Sistema</a>
        <a href="{{ route('systems.index') }}" class="btn btn-secondary">Voltar para a Lista</a>
        <form action="{{ route('systems.destroy', $system) }}" method="POST" style="display:inline; margin-left: 5px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este sistema? Os módulos e tarefas associados serão desvinculados, mas não excluídos.')">Excluir Sistema</button>
        </form>
    </div>

@endsection