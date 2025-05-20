@extends('layouts.app')

@section('title', 'Sprints - SGB')

@section('content')
    @if(isset($quarter))
        <h2>Sprints do Trimestre/Semestre: {{ $quarter->name }}</h2>
        <p><a href="{{ route('quarters.show', $quarter->id) }}">&laquo; Voltar para o Trimestre/Semestre</a></p>
    @else
        <h2>Lista de Todas as Sprints</h2>
    @endif

    @if(isset($quarter))
        <a href="{{ route('sprints.create', ['quarter_id' => $quarter->id]) }}" class="btn btn-primary" style="margin-bottom: 15px;">Nova Sprint para este Período</a>
    @else
        <a href="{{ route('sprints.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Nova Sprint</a>
    @endif

    @if ($sprints->isEmpty())
        <p>Nenhuma sprint cadastrada{{ isset($quarter) ? ' para este período' : '' }}.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome da Sprint</th>
                    <th>Trimestre/Semestre</th>
                    <th>Data de Início</th>
                    <th>Data de Fim</th>
                    <th>Tarefas (Início/Entrega)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sprints as $sprint)
                    <tr>
                        <td>{{ $sprint->name }}</td>
                        <td>
                            @if($sprint->quarter)
                                <a href="{{ route('quarters.show', $sprint->quarter->id) }}">{{ $sprint->quarter->name }}</a>
                            @else
                                N/D
                            @endif
                        </td>
                        <td>{{ $sprint->start_date ? \Carbon\Carbon::parse($sprint->start_date)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $sprint->end_date ? \Carbon\Carbon::parse($sprint->end_date)->format('d/m/Y') : '-' }}</td>
                        <td>
                            {{-- Otimizado se usar withCount no controller --}}
                            {{ ($sprint->start_tasks_count ?? $sprint->startTasks()->count()) }} /
                            {{ ($sprint->delivery_tasks_count ?? $sprint->deliveryTasks()->count()) }}
                        </td>
                        <td>
                            <a href="{{ route('sprints.show', $sprint) }}" class="btn btn-sm btn-secondary">Ver</a>
                            <a href="{{ route('sprints.edit', $sprint) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('sprints.destroy', $sprint) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta sprint? As tarefas associadas serão desvinculadas, mas não excluídas.')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginação --}}
        <div style="margin-top: 20px;">
            {{ $sprints->appends(request()->query())->links() }} {{-- appends para manter o filtro na paginação --}}
        </div>
    @endif
@endsection