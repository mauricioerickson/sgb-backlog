@extends('layouts.app')

@section('title', __('sgb.tasks') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.tasks') }}</h2>
        <a href="{{ route('tasks.create') }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
            {{ __('sgb.new_task') }}
        </a>
    </div>

    {{-- Formulário de Filtros --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg shadow">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="form-group"> {{-- Use sua classe .sgb-form-group ou classes Tailwind diretas --}}
                <label for="filter_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.status_label') }}</label>
                <select name="status" id="filter_status" onchange="this.form.submit()"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('Todos') }}</option>
                    @foreach($statuses as $statusValue) {{-- Assegure que $statuses é passado pelo controller --}}
                        <option value="{{ $statusValue }}" {{ request('status') == $statusValue ? 'selected' : '' }}>{{ $statusValue }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="filter_priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.priority_label') }}</label>
                <select name="priority" id="filter_priority" onchange="this.form.submit()"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('Todas') }}</option>
                    @foreach($priorities as $priorityValue) {{-- Assegure que $priorities é passado pelo controller --}}
                        <option value="{{ $priorityValue }}" {{ request('priority') == $priorityValue ? 'selected' : '' }}>{{ $priorityValue }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="filter_assignee" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.assignee_label_optional') }}</label>
                <select name="assignee_user_id" id="filter_assignee" onchange="this.form.submit()"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('Todos') }}</option>
                    @foreach($users as $user) {{-- Assegure que $users é passado pelo controller --}}
                        <option value="{{ $user->id }}" {{ request('assignee_user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="filter_feature" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.feature') }}</label>
                <select name="feature_id" id="filter_feature" onchange="this.form.submit()"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('Todas') }}</option>
                    @foreach($features as $feature) {{-- Assegure que $features é passado pelo controller --}}
                        <option value="{{ $feature->id }}" {{ request('feature_id') == $feature->id ? 'selected' : '' }}>{{ Str::limit($feature->title, 30) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4">
            {{-- Botão Filtrar é opcional se os selects já submetem com onchange --}}
            {{-- <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-md shadow-sm">Filtrar</button> --}}
            <a href="{{ route('tasks.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">{{ __('sgb.clear_filters') }}</a>
        </div>
    </form>

    @if ($tasks->isEmpty())
        <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
            <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_tasks_found') }}</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('sgb.task_title_label') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('sgb.feature') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('sgb.status_label') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('sgb.priority_label') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('sgb.assignee_label_optional') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('sgb.due_date_label_optional') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('sgb.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $task->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ Str::limit($task->title, 40) }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($task->feature)
                                    <a href="{{ route('features.show', $task->feature_id) }}">{{ Str::limit($task->feature->title, 30) }}</a>
                                @else
                                    {{ __('N/D') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @switch($task->status)
                                        @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                                        @case('Em Andamento') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                                        @case('Bloqueada')
                                        @case('Cancelada') bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100 @break
                                        @case('Pausado') bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @break
                                        @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100
                                    @endswitch">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold
                                @switch($task->priority)
                                    @case('Crítica') text-red-600 dark:text-red-400 @break
                                    @case('Alta') text-yellow-600 dark:text-yellow-400 @break
                                    @case('Média') text-blue-600 dark:text-blue-400 @break
                                    @default text-gray-600 dark:text-gray-300
                                @endswitch
                            ">
                                {{ $task->priority }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $task->assignee->name ?? __('N/D') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('sgb.view') }}</a>
                                <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">{{ __('sgb.edit') }}</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_cascade', ['related_items' => strtolower(__('sgb.comments'))]) }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">{{ __('sgb.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($tasks->hasPages())
            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        @endif
    @endif
@endsection