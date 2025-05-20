@extends('layouts.app')

@section('title', 'Editar Tarefa - SGB')

@section('content')
    <h2>Editar Tarefa: {{ $task->title }}</h2>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @method('PUT')
        @include('tasks._form', [
            // A variável $task já está disponível nesta view, o _form irá usá-la
            'selectedFeatureId' => null, // Não necessário aqui, o old() ou $task->feature_id cuidam disso
            'selectedModuleId' => null,
            'selectedStartSprintId' => null
        ])
    </form>
@endsection