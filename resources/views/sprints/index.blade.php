@extends('layouts.app')

@section('title', __('sgb.sprints') . (isset($quarter) ? ' ' . __('de') . ' ' . $quarter->name : '') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            @if(isset($quarter))
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.sprints') }} {{ __('de') }} {{ $quarter->name }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <a href="{{ route('quarters.show', $quarter->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">&laquo; {{ __('sgb.back_to_quarter') }}</a> {{-- Chave nova: sgb.back_to_quarter --}}
                </p>
            @else
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.sprints') }}</h2>
            @endif
        </div>
        @if(isset($quarter))
            <a href="{{ route('sprints.create', ['quarter_id' => $quarter->id]) }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.new_sprint_for_quarter') }} {{-- Chave nova: sgb.new_sprint_for_quarter --}}
            </a>
        @else
            <a href="{{ route('sprints.create') }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.new_sprint') }}
            </a>
        @endif
    </div>

    @if ($sprints->isEmpty())
        <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
            <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_sprints_found') }}{{ isset($quarter) ? ' ' . __('para este período') : '' }}.</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.sprint_name_label') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.quarter') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.start_date') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.end_date') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.tasks') }} (Início/Entrega)
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($sprints as $sprint)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('sprints.show', $sprint) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $sprint->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($sprint->quarter)
                                    <a href="{{ route('quarters.show', $sprint->quarter->id) }}">{{ $sprint->quarter->name }}</a>
                                @else
                                    {{ __('N/D') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $sprint->start_date ? \Carbon\Carbon::parse($sprint->start_date)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $sprint->end_date ? \Carbon\Carbon::parse($sprint->end_date)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $sprint->start_tasks_count ?? $sprint->startTasks()->count() }} /
                                {{ $sprint->delivery_tasks_count ?? $sprint->deliveryTasks()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('sprints.show', $sprint) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                   {{ __('sgb.view') }}
                                </a>
                                <a href="{{ route('sprints.edit', $sprint) }}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                   {{ __('sgb.edit') }}
                                </a>
                                <form action="{{ route('sprints.destroy', $sprint) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_dissociate', ['related_items' => strtolower(__('sgb.tasks'))]) }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        {{ __('sgb.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        @if ($sprints->hasPages())
            <div class="mt-6">
                {{ $sprints->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
@endsection