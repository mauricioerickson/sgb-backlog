@extends('layouts.app')

@section('title', __('sgb.new_module') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">{{ __('sgb.new_module') }}</h2>

        <form action="{{ route('modules.store') }}" method="POST">
            @csrf
            {{-- Nome do Módulo --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.module_name_label') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sistema Associado --}}
            <div class="mb-6"> {{-- Aumentei a margem inferior antes dos botões --}}
                <label for="system_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.system_associated_label_optional') }}</label>
                <select id="system_id" name="system_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">{{ __('sgb.no_system_global_module') }}</option>
                    @foreach ($systems as $system) {{-- Assegure que $systems é passado pelo controller --}}
                        <option value="{{ $system->id }}"
                            {{ old('system_id', $selectedSystemId ?? '') == $system->id ? 'selected' : '' }}>
                            {{ $system->name }}
                        </option>
                    @endforeach
                </select>
                @error('system_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botões de Ação --}}
            <div class="flex items-center justify-end space-x-4">
                @if(isset($selectedSystemId) && $selectedSystemId)
                    <a href="{{ route('systems.show', $selectedSystemId) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('sgb.cancel') }}
                    </a>
                @else
                    <a href="{{ route('modules.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('sgb.cancel') }}
                    </a>
                @endif
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    {{ __('sgb.save') }} {{-- Ou __('sgb.save_module') se tiver uma chave específica --}}
                </button>
            </div>
        </form>
    </div>
@endsection