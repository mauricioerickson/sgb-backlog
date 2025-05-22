@extends('layouts.app')

@section('title', __('sgb.view_system') . ': ' . $system->name . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('sgb.view_system') }}: <span class="text-blue-600 dark:text-blue-400">{{ $system->name }}</span>
        </h2>
    </div>

    {{-- Detalhes do Sistema --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.system_details') }}</h3> {{-- Chave nova: sgb.system_details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <p><strong>{{ __('sgb.id') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $system->id }}</span></p>
            <p><strong>{{ __('sgb.system_name_label') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $system->name }}</span></p>
            <p><strong>{{ __('sgb.created_at') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $system->created_at ? $system->created_at->format('d/m/Y H:i:s') : '-' }}</span></p>
            <p><strong>{{ __('sgb.updated_at') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $system->updated_at ? $system->updated_at->format('d/m/Y H:i:s') : '-' }}</span></p>
        </div>
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Módulos Associados --}}
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.modules_associated_to_system') }} ({{ $system->modules->count() }})</h3>
            <a href="{{ route('modules.create', ['system_id' => $system->id]) }}"
               class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
               {{ __('sgb.new_module_for_system') }}
            </a>
        </div>

        @if($system->modules && $system->modules->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <ul class="list-disc list-inside space-y-2 text-sm">
                    @foreach($system->modules as $module)
                        <li class="text-gray-700 dark:text-gray-300">
                            <a href="{{ route('modules.show', $module->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $module->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_modules_for_system') }}</p>
            </div>
        @endif
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Tarefas Associadas Diretamente ao Sistema (ou via Módulos) --}}
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">{{ __('sgb.tasks_associated_to_system') }} ({{ $system->tasks->count() }})</h3>
        @if($system->tasks && $system->tasks->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <ul class="space-y-3">
                    @foreach($system->tasks as $task)
                        <li class="py-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                            <div class="flex justify-between items-center">
                                <div>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 font-medium">{{ $task->title }}</a>
                                    @if($task->module)
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">({{ __('sgb.module') }}: {{ $task->module->name }})</span>
                                    @endif
                                </div>
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
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_tasks_for_system_direct_or_via_modules') }}</p> {{-- Chave nova: sgb.no_tasks_for_system_direct_or_via_modules --}}
            </div>
        @endif
    </div>

    {{-- Botões de Ação do Sistema --}}
    <div class="mt-8 flex items-center justify-start space-x-3">
        <a href="{{ route('systems.edit', $system) }}"
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
           {{ __('sgb.edit_system') }}
        </a>
        <a href="{{ route('systems.index') }}"
           class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
           {{ __('sgb.back_to_list') }}
        </a>
        <form action="{{ route('systems.destroy', $system) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_dissociate', ['related_items' => strtolower(__('sgb.modules')) . ' e ' . strtolower(__('sgb.tasks'))]) }}');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.delete_system') }} {{-- Chave nova: sgb.delete_system --}}
            </button>
        </form>
    </div>

@endsection