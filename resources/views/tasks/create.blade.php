@extends('layouts.app')

@section('title', 'Nova Tarefa - SGB')

@section('content')
    <h2>Nova Tarefa</h2>

    <form action="{{ route('tasks.store') }}" method="POST">
        @include('tasks._form', [
            'task' => null, // Não temos um objeto $task na criação
            'selectedFeatureId' => $selectedFeatureId ?? null,
            'selectedModuleId' => $selectedModuleId ?? null,
            'selectedStartSprintId' => $selectedStartSprintId ?? null
        ])
    </form>
@endsection