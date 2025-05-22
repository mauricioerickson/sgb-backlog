@extends('layouts.app')

@section('title', __('sgb.edit_main_objective') . ': ' . $mainObjective->title . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">
            {{ __('sgb.edit_main_objective') }}: <span class="text-blue-600 dark:text-blue-400">{{ $mainObjective->title }}</span>
        </h2>

        <form action="{{ route('main-objectives.update', $mainObjective) }}" method="POST">
            @csrf
            @method('PUT') {{-- Importante para o método update --}}

            {{-- Título --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.objective_title_label') }}</label>
                <input type="text" id="title" name="title" value="{{ old('title', $mainObjective->title) }}" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descrição --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.description_label') }}</label>
                <textarea id="description" name="description" rows="3"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">{{ old('description', $mainObjective->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Trimestre/Semestre --}}
            <div class="mb-4">
                <label for="quarter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.quarter_associated_label') }}</label>
                <select id="quarter_id" name="quarter_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('sgb.select_quarter') }}</option>
                    @foreach ($quarters as $quarter) {{-- Assegure que $quarters é passado pelo controller --}}
                        <option value="{{ $quarter->id }}" {{ old('quarter_id', $mainObjective->quarter_id) == $quarter->id ? 'selected' : '' }}>
                            {{ $quarter->name }}
                        </option>
                    @endforeach
                </select>
                @error('quarter_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Responsável --}}
            <div class="mb-4">
                <label for="responsible_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.responsible_label') }}</label>
                <select id="responsible_user_id" name="responsible_user_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('sgb.select_responsible') }}</option>
                    @foreach ($users as $user) {{-- Assegure que $users é passado pelo controller --}}
                        <option value="{{ $user->id }}" {{ old('responsible_user_id', $mainObjective->responsible_user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('responsible_user_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.status_label') }}</label>
                <select id="status" name="status" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach ($statuses as $statusValue) {{-- Assegure que $statuses é passado pelo controller --}}
                        <option value="{{ $statusValue }}" {{ old('status', $mainObjective->status) == $statusValue ? 'selected' : '' }}>
                            {{ $statusValue }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notas Adicionais --}}
            <div class="mb-6"> {{-- Aumentei a margem inferior antes dos botões --}}
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.notes_label') }}</label>
                <textarea id="notes" name="notes" rows="3"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">{{ old('notes', $mainObjective->notes) }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botões de Ação --}}
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('main-objectives.show', $mainObjective) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('sgb.cancel') }}
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    {{ __('sgb.update') }} {{-- Usando a chave 'sgb.update' --}}
                </button>
            </div>
        </form>
    </div>
@endsection