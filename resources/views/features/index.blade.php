@extends('layouts.app')

@section('title', 'Funcionalidades - SGB')

@section('content')
    @if(isset($mainObjective))
        <h2>Funcionalidades do Objetivo: {{ $mainObjective->title }}</h2>
        <p><a href="{{ route('main-objectives.show', $mainObjective->id) }}">&laquo; Voltar para o Objetivo</a></p>
    @else
        <h2>Lista de Todas as Funcionalidades</h2>
    @endif


    @if(isset($mainObjective))
        <a href="{{ route('features.create', ['objective_id' => $mainObjective->id]) }}" class="btn btn-primary" style="margin-bottom: 15px;">Nova Funcionalidade para este Objetivo</a>
    @else
        <a href="{{ route('features.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Nova Funcionalidade</a>
    @endif


    @if ($features->isEmpty())
        <p>Nenhuma funcionalidade cadastrada{{ isset($mainObjective) ? ' para este objetivo' : '' }}.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Objetivo Principal</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($features as $feature)
                    <tr>
                        <td>{{ $feature->title }}</td>
                        <td>
                            @if($feature->mainObjective)
                                <a href="{{ route('main-objectives.show', $feature->mainObjective->id) }}">{{ $feature->mainObjective->title }}</a>
                            @else
                                N/D
                            @endif
                        </td>
                        <td>{{ $feature->status }}</td>
                        <td>
                            <a href="{{ route('features.show', $feature) }}" class="btn btn-sm btn-secondary">Ver</a>
                            <a href="{{ route('features.edit', $feature) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('features.destroy', $feature) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta funcionalidade? Todas as tarefas associadas também serão excluídas.')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginação --}}
        <div style="margin-top: 20px;">
            {{ $features->appends(request()->query())->links() }} {{-- appends para manter o filtro na paginação --}}
        </div>
    @endif
@endsection