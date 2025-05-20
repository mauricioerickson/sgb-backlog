@extends('layouts.app')

@section('title', 'Módulos - SGB')

@section('content')
    @if(isset($system))
        <h2>Módulos do Sistema: {{ $system->name }}</h2>
        <p><a href="{{ route('systems.show', $system->id) }}">&laquo; Voltar para o Sistema</a></p>
    @else
        <h2>Lista de Todos os Módulos</h2>
    @endif

    @if(isset($system))
        <a href="{{ route('modules.create', ['system_id' => $system->id]) }}" class="btn btn-primary" style="margin-bottom: 15px;">Novo Módulo para este Sistema</a>
    @else
        <a href="{{ route('modules.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Novo Módulo</a>
    @endif

    @if ($modules->isEmpty())
        <p>Nenhum módulo cadastrado{{ isset($system) ? ' para este sistema' : '' }}.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome do Módulo</th>
                    <th>Sistema Associado</th>
                    <th>Tarefas Associadas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modules as $module)
                    <tr>
                        <td>{{ $module->name }}</td>
                        <td>
                            @if($module->system)
                                <a href="{{ route('systems.show', $module->system->id) }}">{{ $module->system->name }}</a>
                            @else
                                N/D (Módulo Global)
                            @endif
                        </td>
                        <td>{{ $module->tasks_count ?? $module->tasks()->count() }}</td> {{-- Otimizado se usar withCount --}}
                        <td>
                            <a href="{{ route('modules.show', $module) }}" class="btn btn-sm btn-secondary">Ver</a>
                            <a href="{{ route('modules.edit', $module) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('modules.destroy', $module) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este módulo? As tarefas associadas serão desvinculadas, mas não excluídas.')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginação --}}
        <div style="margin-top: 20px;">
            {{ $modules->appends(request()->query())->links() }} {{-- appends para manter o filtro na paginação --}}
        </div>
    @endif
@endsection