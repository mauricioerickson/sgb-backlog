@extends('layouts.app')

@section('title', 'Objetivos Principais - SGB')

@section('content')
    <h2>Lista de Objetivos Principais</h2>

    <a href="{{ route('main-objectives.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Novo Objetivo Principal</a>

    @if ($mainObjectives->isEmpty())
        <p>Nenhum objetivo principal cadastrado.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Trimestre/Semestre</th>
                    <th>Responsável</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mainObjectives as $objective)
                    <tr>
                        <td>{{ $objective->title }}</td>
                        <td>{{ $objective->quarter ? $objective->quarter->name : 'N/D' }}</td>
                        <td>{{ $objective->responsibleUser ? $objective->responsibleUser->name : 'N/D' }}</td>
                        <td>{{ $objective->status }}</td>
                        <td>
                            <a href="{{ route('main-objectives.show', $objective) }}" class="btn btn-secondary">Ver</a>
                            <a href="{{ route('main-objectives.edit', $objective) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('main-objectives.destroy', $objective) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este objetivo? Todas as funcionalidades associadas também serão excluídas.')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginação --}}
        <div style="margin-top: 20px;">
            {{ $mainObjectives->links() }}
        </div>
    @endif
@endsection