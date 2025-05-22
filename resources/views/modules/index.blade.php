@extends('layouts.app')

@section('title', __('sgb.modules') . (isset($system) ? ' ' . __('de') . ' ' . $system->name : '') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="flex justify-between items-center mb-6">
        @if(isset($system))
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.modules') }} {{ __('de') }} {{ $system->name }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <a href="{{ route('systems.show', $system->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">&laquo; {{ __('sgb.back_to_system') }}</a>
                </p>
            </div>
            <a href="{{ route('modules.create', ['system_id' => $system->id]) }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.new_module_for_system') }}
            </a>
        @else
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.modules') }}</h2>
            <a href="{{ route('modules.create') }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.new_module') }}
            </a>
        @endif
    </div>

    @if ($modules->isEmpty())
        <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
            <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_modules_found') }}{{ isset($system) ? ' ' . __('para este sistema') : '' }}.</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.module_name_label') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.system_associated') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.tasks_associated_to_module') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($modules as $module)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('modules.show', $module) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $module->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($module->system)
                                    <a href="{{ route('systems.show', $module->system->id) }}">{{ $module->system->name }}</a>
                                @else
                                    {{ __('sgb.no_system_global_module') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $module->tasks_count ?? $module->tasks()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('modules.show', $module) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                   {{ __('sgb.view') }}
                                </a>
                                <a href="{{ route('modules.edit', $module) }}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                   {{ __('sgb.edit') }}
                                </a>
                                <form action="{{ route('modules.destroy', $module) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_dissociate', ['related_items' => strtolower(__('sgb.tasks'))]) }}');">
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
        @if ($modules->hasPages())
            <div class="mt-6">
                {{ $modules->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
@endsection