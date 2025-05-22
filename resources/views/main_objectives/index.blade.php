@extends('layouts.app')

@section('title', __('sgb.main_objectives') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.main_objectives') }}</h2>
        <a href="{{ route('main-objectives.create') }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
            {{ __('sgb.new_main_objective') }}
        </a>
    </div>

    @if ($mainObjectives->isEmpty())
        <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
            <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_main_objectives_found') }}</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.objective_title_label') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.quarter') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.responsible_label') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.status_label') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($mainObjectives as $objective)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('main-objectives.show', $objective) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $objective->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $objective->quarter ? $objective->quarter->name : __('N/D') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $objective->responsibleUser ? $objective->responsibleUser->name : __('N/D') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @switch($objective->status)
                                        @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                                        @case('Em Andamento') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                                        @case('Pausado') bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @break
                                        @case('Aguardando Início') bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100 @break
                                        @default bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100 {{-- Não Iniciado ou outros --}}
                                    @endswitch">
                                    {{ $objective->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('main-objectives.show', $objective) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                   {{ __('sgb.view') }}
                                </a>
                                <a href="{{ route('main-objectives.edit', $objective) }}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                   {{ __('sgb.edit') }}
                                </a>
                                <form action="{{ route('main-objectives.destroy', $objective) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_cascade', ['related_items' => strtolower(__('sgb.features'))]) }}');">
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
        @if ($mainObjectives->hasPages())
            <div class="mt-6">
                {{ $mainObjectives->links() }} {{-- O Laravel Breeze já estiliza a paginação para Tailwind --}}
            </div>
        @endif
    @endif
@endsection