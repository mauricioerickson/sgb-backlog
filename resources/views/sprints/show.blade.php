@extends('layouts.app')

@section('title', __('sgb.view_sprint') . ': ' . $sprint->name . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('sgb.view_sprint') }}: <span class="text-blue-600 dark:text-blue-400">{{ $sprint->name }}</span>
        </h2>
    </div>

    {{-- Detalhes da Sprint --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.sprint_details') }}</h3> {{-- Chave nova: sgb.sprint_details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <p><strong>{{ __('sgb.id') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $sprint->id }}</span></p>
            <p><strong>{{ __('sgb.sprint_name_label') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $sprint->name }}</span></p>
            <p><strong>{{ __('sgb.start_date_label_optional') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $sprint->start_date ? \Carbon\Carbon::parse($sprint->start_date)->format('d/m/Y') : __('sgb.not_available_short') }}</span></p>
            <p><strong>{{ __('sgb.end_date_label_optional') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $sprint->end_date ? \Carbon\Carbon::parse($sprint->end_date)->format('d/m/Y') : __('sgb.not_available_short') }}</span></p>
            <div class="md:col-span-2"> {{-- Ocupa duas colunas se houver --}}
                <strong>{{ __('sgb.quarter_associated_label_optional') }}</strong>
                @if($sprint->quarter)
                    <a href="{{ route('quarters.show', $sprint->quarter->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $sprint->quarter->name }}</a>
                @else
                    <span class="text-gray-600 dark:text-gray-400">{{ __('sgb.not_available_short') }}</span>
                @endif
            </div>
            <p><strong>{{ __('sgb.created_at') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $sprint->created_at ? $sprint->created_at->format('d/m/Y H:i:s') : '-' }}</span></p>
            <p><strong>{{ __('sgb.updated_at') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $sprint->updated_at ? $sprint->updated_at->format('d/m/Y H:i:s') : '-' }}</span></p>
        </div>
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Tarefas com Início na Sprint --}}
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">{{ __('sgb.tasks_starting_in_sprint') }} ({{ $sprint->startTasks->count() }})</h3>
        @if($sprint->startTasks && $sprint->startTasks->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <ul class="list-disc list-inside space-y-2 text-sm">
                    @foreach($sprint->startTasks as $task)
                        <li class="text-gray-700 dark:text-gray-300">
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $task->title }}</a>
                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ __('sgb.status_label') }} {{ $task->status }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_tasks_starting_in_sprint') }}</p>
            </div>
        @endif
    </div>

    {{-- Tarefas com Entrega na Sprint --}}
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">{{ __('sgb.tasks_delivering_in_sprint') }} ({{ $sprint->deliveryTasks->count() }})</h3>
        @if($sprint->deliveryTasks && $sprint->deliveryTasks->count() > 0)
             <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <ul class="list-disc list-inside space-y-2 text-sm">
                    @foreach($sprint->deliveryTasks as $task)
                        <li class="text-gray-700 dark:text-gray-300">
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $task->title }}</a>
                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ __('sgb.status_label') }} {{ $task->status }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_tasks_delivering_in_sprint') }}</p>
            </div>
        @endif
    </div>

    {{-- Link para adicionar tarefas a esta sprint (opcional) --}}
    {{--
    <div class="mb-8">
        <a href="{{ route('tasks.create', ['start_sprint_id' => $sprint->id]) }}"
           class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md shadow-sm">
           {{ __('sgb.new_task_for_sprint') }} -- Chave nova: sgb.new_task_for_sprint
        </a>
    </div>
    --}}

    {{-- Botões de Ação da Sprint --}}
    <div class="mt-8 flex items-center justify-start space-x-3">
        <a href="{{ route('sprints.edit', $sprint) }}"
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
           {{ __('sgb.edit_sprint') }}
        </a>
        @if($sprint->quarter)
            <a href="{{ route('sprints.index', ['quarter_id' => $sprint->quarter_id]) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('sgb.back_to_sprints_of_quarter') }} {{-- Chave nova: sgb.back_to_sprints_of_quarter --}}
            </a>
        @else
            <a href="{{ route('sprints.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('sgb.back_to_list') }}
            </a>
        @endif
        <form action="{{ route('sprints.destroy', $sprint) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_dissociate', ['related_items' => strtolower(__('sgb.tasks'))]) }}');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.delete_sprint') }} {{-- Chave nova: sgb.delete_sprint --}}
            </button>
        </form>
    </div>

@endsection