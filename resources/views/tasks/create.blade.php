@extends('layouts.app')

@section('title', __('sgb.new_task') . ' - ' . __('sgb.sgb'))

@section('content')
    {{-- O partial _form.blade.php usa fieldsets. Para um formulário longo como o de tarefas,
         podemos usar um container um pouco mais largo, como max-w-4xl. --}}
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 md:p-8">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">{{ __('sgb.new_task') }}</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @include('tasks._form', [
                'task' => null, // Em create, não temos um objeto $task existente
                // As variáveis abaixo são passadas pelo TaskController@create para o _form
                // e já são usadas dentro do _form para pré-seleção se vierem da URL.
                // Não é estritamente necessário repassá-las explicitamente aqui no @include
                // se o _form já as acessa corretamente através do escopo da view create.
                // Mas, para clareza ou se o _form for muito isolado, pode-se passar.
                // 'selectedFeatureId' => $selectedFeatureId ?? null,
                // 'selectedModuleId' => $selectedModuleId ?? null,
                // 'selectedStartSprintId' => $selectedStartSprintId ?? null,

                // As coleções (features, systems, etc.) são passadas pelo TaskController@create
                // e já estão disponíveis para o _form.blade.php
            ])
        </form>
    </div>
@endsection