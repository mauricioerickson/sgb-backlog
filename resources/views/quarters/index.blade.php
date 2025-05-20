@extends('layouts.app')

@section('title', 'Trimestres/Semestres - SGB')

@section('content')
    <h2>Lista de Trimestres/Semestres</h2>

    <a href="{{ route('quarters.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Novo Trimestre/Semestre</a>

    @if ($quarters->isEmpty())
        <p>Nenhum trimestre/semestre cadastrado.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Início</th>
                    <th>Data de Fim</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quarters as $quarter)
                    <tr>
                        <td>{{ $quarter->name }}</td>
                        <td>{{ $quarter->start_date ? \Carbon\Carbon::parse($quarter->start_date)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $quarter->end_date ? \Carbon\Carbon::parse($quarter->end_date)->format('d/m/Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('quarters.show', $quarter) }}" class="btn btn-secondary">Ver</a>
                            <a href="{{ route('quarters.edit', $quarter) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('quarters.destroy', $quarter) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este item?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginação --}}
        <div style="margin-top: 20px;">
            {{ $quarters->links() }}
        </div>
    @endif
@endsection