@extends('layouts.app')

@section('title', __('sgb.edit_sprint') . ': ' . $sprint->name . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">
            {{ __('sgb.edit_sprint') }}: <span class="text-blue-600 dark:text-blue-400">{{ $sprint->name }}</span>
        </h2>

        <form action="{{ route('sprints.update', $sprint) }}" method="POST">
            @csrf
            @method('PUT') {{-- Importante para o método update --}}

            {{-- Nome da Sprint --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.sprint_name_label') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name', $sprint->name) }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Data de Início --}}
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.start_date_label_optional') }}</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $sprint->start_date) }}"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                @error('start_date')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Data de Fim --}}
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.end_date_label_optional') }}</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $sprint->end_date) }}"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                @error('end_date')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Trimestre/Semestre Associado --}}
            <div class="mb-6"> {{-- Aumentei a margem inferior antes dos botões --}}
                <label for="quarter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.quarter_associated_label_optional') }}</label>
                <select id="quarter_id" name="quarter_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('sgb.none_male') }}</option> {{-- Ou sgb.none_generic --}}
                    @foreach ($quarters as $quarter) {{-- Assegure que $quarters é passado pelo controller --}}
                        <option value="{{ $quarter->id }}"
                            {{ old('quarter_id', $sprint->quarter_id) == $quarter->id ? 'selected' : '' }}>
                            {{ $quarter->name }}
                        </option>
                    @endforeach
                </select>
                @error('quarter_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botões de Ação --}}
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('sprints.show', $sprint) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('sgb.cancel') }}
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    {{ __('sgb.update') }} {{-- Ou __('sgb.update_sprint') se tiver uma chave específica --}}
                </button>
            </div>
        </form>
    </div>
@endsection