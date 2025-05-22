@extends('layouts.app')

@section('title', __('sgb.features') . (isset($mainObjective) ? ' ' . __('de') . ' ' . $mainObjective->title : '') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="flex justify-between items-start mb-6">
        <div>
            @if(isset($mainObjective))
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.features') }} {{ __('de') }} "{{ $mainObjective->title }}"</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <a href="{{ route('main-objectives.show', $mainObjective->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">&laquo; {{ __('sgb.back_to_objective') }}</a> {{-- Chave nova: sgb.back_to_objective --}}
                </p>
            @else
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.features') }}</h2>
            @endif
        </div>
        <div>
            @if(isset($mainObjective))
                <a href="{{ route('features.create', ['objective_id' => $mainObjective->id]) }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                    {{ __('sgb.new_feature_for_objective') }}
                </a>
            @else
                <a href="{{ route('features.create') }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                    {{ __('sgb.new_feature') }}
                </a>
            @endif
        </div>
    </div>

    @if ($features->isEmpty())
        <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
            <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_features_found') }}{{ isset($mainObjective) ? ' ' . __('para este objetivo') : '' }}.</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.feature_title_label') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('sgb.main_objective') }}
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
                    @foreach ($features as $feature)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('features.show', $feature) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $feature->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($feature->mainObjective)
                                    <a href="{{ route('main-objectives.show', $feature->mainObjective->id) }}">{{ Str::limit($feature->mainObjective->title, 35) }}</a>
                                @else
                                    {{ __('N/D') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @switch($feature->status)
                                        @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                                        @case('Em Andamento') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                                        @case('Pausado') bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @break
                                        @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100 {{-- Não Iniciado ou outros --}}
                                    @endswitch">
                                    {{ $feature->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('features.show', $feature) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                   {{ __('sgb.view') }}
                                </a>
                                <a href="{{ route('features.edit', $feature) }}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                   {{ __('sgb.edit') }}
                                </a>
                                <form action="{{ route('features.destroy', $feature) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_cascade', ['related_items' => strtolower(__('sgb.tasks'))]) }}');">
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
        @if ($features->hasPages())
            <div class="mt-6">
                {{ $features->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
@endsection