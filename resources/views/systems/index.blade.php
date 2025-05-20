@extends('layouts.app')

@section('title', 'Sistemas - SGB')

@section('content')
    <h2>Lista de Sistemas</h2>

    <a href="{{ route('systems.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Novo Sistema</a>

    @if ($systems->isEmpty())
        <p>Nenhum sistema cadastrado.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome do Sistema</th>
                    <th>Módulos Associados</th>
                    <th>Tarefas Associadas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($systems as $system)
                    <tr>
                        <td>{{ $system->name }}</td>
                        <td>{{ $system->modules_count ?? $system->modules()->count() }}</td> {{-- Otimizado se usar withCount --}}
                        <td>{{ $system->tasks_count ?? $system->tasks()->count() }}</td>   {{-- Otimizado se usar withCount --}}
                        <td>
                            <a href="{{ route('systems.show', $system) }}" class="btn btn-sm btn-secondary">Ver</a>
                            <a href="{{ route('systems.edit', $system) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('systems.destroy', $system) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este sistema? Os módulos e tarefas associados serão desvinculados, mas não excluídos.')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginação --}}
        <div style="margin-top: 20px;">
            {{ $systems->links() }}
        </div>
    @endif
@endsection