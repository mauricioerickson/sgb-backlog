@extends('layouts.app')

@section('title', __('sgb.systems') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.systems') }}</h2>
        <a href="{{ route('systems.create') }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
            {{ __('sgb.new_system') }}
        </a>
    </div>

    @if ($systems->isEmpty())
        <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
            <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_systems_found') }}</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.system_name_label') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.modules_associated_to_system_short') }} {{-- Ex: Módulos --}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.tasks_associated_to_system_short') }} {{-- Ex: Tarefas --}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($systems as $system)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('systems.show', $system) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $system->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{-- Para otimizar, use withCount(['modules']) no controller --}}
                                {{ $system->modules_count ?? $system->modules()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{-- Para otimizar, use withCount(['tasks']) no controller --}}
                                {{ $system->tasks_count ?? $system->tasks()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('systems.show', $system) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                   {{ __('sgb.view') }}
                                </a>
                                <a href="{{ route('systems.edit', $system) }}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                   {{ __('sgb.edit') }}
                                </a>
                                <form action="{{ route('systems.destroy', $system) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_dissociate', ['related_items' => strtolower(__('sgb.modules')) . ' e ' . strtolower(__('sgb.tasks'))]) }}');">
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
        @if ($systems->hasPages())
            <div class="mt-6">
                {{ $systems->links() }}
            </div>
        @endif
    @endif
@endsection