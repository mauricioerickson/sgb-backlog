@extends('layouts.app')

@section('title', 'Tarefas - SGB')

@section('content')
    <h2>Lista de Tarefas</h2>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Nova Tarefa</a>

    {{-- Formulário de Filtros --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="filter-form" style="margin-bottom:20px; padding:15px; border:1px solid #eee; border-radius:5px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label for="filter_status">Status:</label>
                <select name="status" id="filter_status" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="filter_priority">Prioridade:</label>
                <select name="priority" id="filter_priority" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    @foreach($priorities as $priority)
                        <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="filter_assignee">Responsável:</label>
                <select name="assignee_user_id" id="filter_assignee" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('assignee_user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="filter_feature">Funcionalidade:</label>
                <select name="feature_id" id="filter_feature" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    @foreach($features as $feature)
                        <option value="{{ $feature->id }}" {{ request('feature_id') == $feature->id ? 'selected' : '' }}>{{ Str::limit($feature->title, 30) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary btn-sm" style="display:none;">Filtrar</button> {{-- Escondido, pois o onchange submete --}}
        <a href="{{ route('tasks.index') }}" class="btn btn-sm">Limpar Filtros</a>
    </form>


    @if ($tasks->isEmpty())
        <p>Nenhuma tarefa encontrada.</p>
    @else
        <div style="overflow-x:auto;"> {{-- Para tabelas largas em telas pequenas --}}
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Funcionalidade</th>
                    <th>Status</th>
                    <th>Prioridade</th>
                    <th>Responsável</th>
                    <th>Vencimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td><a href="{{ route('tasks.show', $task) }}">{{ Str::limit($task->title, 40) }}</a></td>
                        <td>
                            @if($task->feature)
                                <a href="{{ route('features.show', $task->feature_id) }}">{{ Str::limit($task->feature->title, 30) }}</a>
                            @else
                                N/D
                            @endif
                        </td>
                        <td>{{ $task->status }}</td>
                        <td style="color:
                            @switch($task->priority)
                                @case('Crítica') red @break
                                @case('Alta') orange @break
                                @default #333 @break
                            @endswitch
                        ">{{ $task->priority }}</td>
                        <td>{{ $task->assignee->name ?? 'N/D' }}</td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/y') : '-' }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-secondary">Ver</a>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta tarefa? Todos os comentários associados também serão excluídos.')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $tasks->links() }}
        </div>
    @endif
@endsection