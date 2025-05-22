@extends('layouts.app')

@section('title', __('sgb.new_system') . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">{{ __('sgb.new_system') }}</h2>

        <form action="{{ route('systems.store') }}" method="POST">
            @csrf
            {{-- Nome do Sistema --}}
            <div class="mb-6"> {{-- Aumentei a margem inferior antes dos botões --}}
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.system_name_label') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botões de Ação --}}
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('systems.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('sgb.cancel') }}
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    {{ __('sgb.save') }} {{-- Ou __('sgb.save_system') se tiver uma chave específica --}}
                </button>
            </div>
        </form>
    </div>
@endsection