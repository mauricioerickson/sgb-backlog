@extends('layouts.app')

@section('title', __('sgb.view_feature') . ': ' . $feature->title . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('sgb.view_feature') }}: <span class="text-blue-600 dark:text-blue-400">{{ $feature->title }}</span>
        </h2>
    </div>

    {{-- Detalhes da Funcionalidade --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.feature_details') }}</h3> {{-- Chave nova: sgb.feature_details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div>
                <p class="font-semibold">{{ __('sgb.id') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $feature->id }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.feature_title_label') }}</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $feature->title }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="font-semibold">{{ __('sgb.description_label') }}</p>
                <div class="mt-1 text-gray-600 dark:text-gray-400 prose prose-sm dark:prose-invert max-w-none">{!! nl2br(e($feature->description)) ?: __('sgb.not_available_short') !!}</div>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.main_objective_associated_label') }}</p>
                @if($feature->mainObjective)
                    <a href="{{ route('main-objectives.show', $feature->mainObjective->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $feature->mainObjective->title }}</a>
                @else
                    <p class="text-gray-600 dark:text-gray-400">{{ __('sgb.not_available_short') }}</p>
                @endif
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.status_label') }}</p>
                <p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        @switch($feature->status)
                            @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                            @case('Em Andamento') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                            @case('Pausado') bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @break
                            @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100
                        @endswitch">
                        {{ $feature->status }}
                    </span>
                </p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.created_at') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $feature->created_at ? $feature->created_at->format('d/m/Y H:i:s') : '-' }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.updated_at') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $feature->updated_at ? $feature->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
            </div>
        </div>
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Tarefas Associadas --}}
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.tasks_associated_to_feature') }} ({{ $feature->tasks->count() }})</h3>
            <a href="{{ route('tasks.create', ['feature_id' => $feature->id]) }}"
               class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
               {{ __('sgb.new_task_for_feature') }}
            </a>
        </div>

        @if($feature->tasks && $feature->tasks->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($feature->tasks as $task)
                        <li class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 font-medium">{{ $task->title }}</a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('sgb.assignee_label_optional') }}: {{ $task->assignee->name ?? __('sgb.not_available_short') }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @switch($task->status)
                                            @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                                            @case('Em Andamento') bg-sky-100 text-sky-800 dark:bg-sky-700 dark:text-sky-100 @break
                                            @case('Bloqueada')
                                            @case('Cancelada') bg-pink-100 text-pink-800 dark:bg-pink-700 dark:text-pink-100 @break
                                            @case('Pausado') bg-orange-100 text-orange-800 dark:bg-orange-600 dark:text-orange-100 @break
                                            @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                                        @endswitch">
                                        {{ $task->status }}
                                    </span>
                                    <span class="text-xs font-semibold
                                        @switch($task->priority)
                                            @case('Crítica') text-red-600 dark:text-red-400 @break
                                            @case('Alta') text-yellow-600 dark:text-yellow-400 @break
                                            @case('Média') text-blue-600 dark:text-blue-400 @break
                                            @default text-gray-500 dark:text-gray-400
                                        @endswitch
                                    ">
                                        {{ $task->priority }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_tasks_for_feature') }}</p>
            </div>
        @endif
    </div>

    {{-- Botões de Ação da Funcionalidade --}}
    <div class="mt-8 flex items-center justify-start space-x-3">
        <a href="{{ route('features.edit', $feature) }}"
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
           {{ __('sgb.edit_feature') }}
        </a>
        @if($feature->mainObjective)
            <a href="{{ route('features.index', ['objective_id' => $feature->mainObjective->id]) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('sgb.back_to_features_of_objective') }} {{-- Chave nova: sgb.back_to_features_of_objective --}}
            </a>
        @else
            <a href="{{ route('features.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('sgb.back_to_list') }}
            </a>
        @endif
        <form action="{{ route('features.destroy', $feature) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_cascade', ['related_items' => strtolower(__('sgb.tasks'))]) }}');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.delete_feature') }} {{-- Chave nova: sgb.delete_feature --}}
            </button>
        </form>
    </div>

@endsection