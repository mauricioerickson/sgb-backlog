@extends('layouts.app')

@section('title', __('sgb.new_feature') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">{{ __('sgb.new_feature') }}</h2>

        <form action="{{ route('features.store') }}" method="POST">
            @csrf
            {{-- Título da Funcionalidade --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.feature_title_label') }}</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descrição --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.description_label') }}</label>
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Objetivo Principal Associado --}}
            <div class="mb-4">
                <label for="objective_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.main_objective_associated_label') }}</label>
                <select id="objective_id" name="objective_id" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('Selecione um Objetivo Principal') }}</option> {{-- Chave nova: sgb.select_main_objective --}}
                    @foreach ($mainObjectives as $objective)
                        <option value="{{ $objective->id }}"
                            {{ old('objective_id', $selectedObjectiveId ?? '') == $objective->id ? 'selected' : '' }}>
                            {{ $objective->title }}
                        </option>
                    @endforeach
                </select>
                @error('objective_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-6"> {{-- Aumentei a margem inferior antes dos botões --}}
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.status_label') }}</label>
                <select id="status" name="status" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach ($statuses as $status) {{-- Assegure que $statuses é passado pelo FeatureController@create --}}
                        <option value="{{ $status }}" {{ old('status', 'Não Iniciado') == $status ? 'selected' : '' }}> {{-- Default para 'Não Iniciado' na criação --}}
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botões de Ação --}}
            <div class="flex items-center justify-end space-x-4">
                @if(isset($selectedObjectiveId) && $selectedObjectiveId)
                    <a href="{{ route('main-objectives.show', $selectedObjectiveId) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('sgb.cancel') }}
                    </a>
                @else
                    <a href="{{ route('features.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('sgb.cancel') }}
                    </a>
                @endif
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    {{ __('sgb.save') }} {{ __('sgb.feature') }}
                </button>
            </div>
        </form>
    </div>
@endsection