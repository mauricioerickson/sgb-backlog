@extends('layouts.app')

@section('title', __('sgb.view_main_objective') . ': ' . $mainObjective->title . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('sgb.view_main_objective') }}: <span class="text-blue-600 dark:text-blue-400">{{ $mainObjective->title }}</span>
        </h2>
    </div>

    {{-- Detalhes do Objetivo Principal --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.main_objective_details') }}</h3> {{-- Chave nova: sgb.main_objective_details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div>
                <p class="font-semibold">{{ __('sgb.id') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $mainObjective->id }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.objective_title_label') }}</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $mainObjective->title }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="font-semibold">{{ __('sgb.description_label') }}</p>
                <div class="mt-1 text-gray-600 dark:text-gray-400 prose prose-sm dark:prose-invert max-w-none">{!! nl2br(e($mainObjective->description)) ?: __('sgb.not_available_short') !!}</div>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.quarter_associated_label') }}</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $mainObjective->quarter ? $mainObjective->quarter->name : __('sgb.not_available_short') }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.responsible_label') }}</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $mainObjective->responsibleUser ? $mainObjective->responsibleUser->name : __('sgb.not_available_short') }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.status_label') }}</p>
                <p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        @switch($mainObjective->status)
                            @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                            @case('Em Andamento') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                            @case('Pausado') bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @break
                            @case('Aguardando Início') bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100 @break
                            @default bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100 {{-- Não Iniciado ou outros --}}
                        @endswitch">
                        {{ $mainObjective->status }}
                    </span>
                </p>
            </div>
            <div class="md:col-span-2">
                <p class="font-semibold">{{ __('sgb.notes_label') }}</p>
                <div class="mt-1 text-gray-600 dark:text-gray-400 prose prose-sm dark:prose-invert max-w-none">{!! nl2br(e($mainObjective->notes)) ?: __('sgb.not_available_short') !!}</div>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.created_at') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $mainObjective->created_at ? $mainObjective->created_at->format('d/m/Y H:i:s') : '-' }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.updated_at') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $mainObjective->updated_at ? $mainObjective->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
            </div>
        </div>
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Funcionalidades Associadas --}}
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.features_associated_to_objective') }} ({{ $mainObjective->features->count() }})</h3>
            <a href="{{ route('features.create', ['objective_id' => $mainObjective->id]) }}"
               class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
               {{ __('sgb.new_feature_for_objective') }}
            </a>
        </div>

        @if($mainObjective->features && $mainObjective->features->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($mainObjective->features as $feature)
                        <li class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('features.show', $feature->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 font-medium">{{ $feature->title }}</a>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @switch($feature->status)
                                        @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                                        @case('Em Andamento') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                                        @case('Pausado') bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @break
                                        @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100
                                    @endswitch">
                                    {{ $feature->status }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_features_for_objective') }}</p>
            </div>
        @endif
    </div>

    {{-- Botões de Ação do Objetivo Principal --}}
    <div class="mt-8 flex items-center justify-start space-x-3">
        <a href="{{ route('main-objectives.edit', $mainObjective) }}"
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
           {{ __('sgb.edit_main_objective') }}
        </a>
        <a href="{{ route('main-objectives.index') }}"
           class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
           {{ __('sgb.back_to_list') }}
        </a>
        <form action="{{ route('main-objectives.destroy', $mainObjective) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_cascade', ['related_items' => strtolower(__('sgb.features'))]) }}');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.delete_main_objective') }} {{-- Chave nova: sgb.delete_main_objective --}}
            </button>
        </form>
    </div>

@endsection