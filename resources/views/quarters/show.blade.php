@extends('layouts.app')

@section('title', __('sgb.view_quarter') . ': ' . $quarter->name . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('sgb.view_quarter') }}: <span class="text-blue-600 dark:text-blue-400">{{ $quarter->name }}</span>
        </h2>
    </div>

    {{-- Detalhes do Período --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.quarter_details') }}</h3> {{-- Chave nova: sgb.quarter_details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div>
                <p class="font-semibold">{{ __('sgb.id') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $quarter->id }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.quarter_name_label') }}</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $quarter->name }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.start_date_label') }}</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $quarter->start_date ? \Carbon\Carbon::parse($quarter->start_date)->format('d/m/Y') : __('sgb.not_available_short') }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.end_date_label') }}</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $quarter->end_date ? \Carbon\Carbon::parse($quarter->end_date)->format('d/m/Y') : __('sgb.not_available_short') }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.created_at') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $quarter->created_at ? $quarter->created_at->format('d/m/Y H:i:s') : '-' }}</p>
            </div>
            <div>
                <p class="font-semibold">{{ __('sgb.updated_at') }}:</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $quarter->updated_at ? $quarter->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
            </div>
        </div>
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Objetivos neste Trimestre/Semestre --}}
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.objectives_in_this_quarter') }} ({{ $quarter->mainObjectives->count() }})</h3> {{-- Chave nova: sgb.objectives_in_this_quarter --}}
            <a href="{{ route('main-objectives.create', ['quarter_id' => $quarter->id]) }}"
               class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
               {{ __('sgb.new_main_objective_for_quarter') }} {{-- Chave nova: sgb.new_main_objective_for_quarter --}}
            </a>
        </div>
        @if($quarter->mainObjectives && $quarter->mainObjectives->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($quarter->mainObjectives as $objective)
                        <li class="py-3">
                             <div class="flex items-center justify-between">
                                <a href="{{ route('main-objectives.show', $objective->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 font-medium">{{ $objective->title }}</a>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @switch($objective->status)
                                        @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                                        @case('Em Andamento') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                                        @case('Pausado') bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @break
                                        @case('Aguardando Início') bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100 @break
                                        @default bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100
                                    @endswitch">
                                    {{ $objective->status }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_main_objectives_for_quarter') }}</p> {{-- Chave nova: sgb.no_main_objectives_for_quarter --}}
            </div>
        @endif
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Sprints neste Trimestre/Semestre --}}
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('sgb.sprints_in_this_quarter') }} ({{ $quarter->sprints->count() }})</h3>
            <a href="{{ route('sprints.create', ['quarter_id' => $quarter->id]) }}"
               class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
               {{ __('sgb.new_sprint_for_quarter') }}
            </a>
        </div>
        @if($quarter->sprints && $quarter->sprints->count() > 0)
             <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($quarter->sprints as $sprint)
                        <li class="py-3">
                            <a href="{{ route('sprints.show', $sprint->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 font-medium">{{ $sprint->name }}</a>
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                ({{ $sprint->start_date ? \Carbon\Carbon::parse($sprint->start_date)->format('d/m') : 'N/D' }} - {{ $sprint->end_date ? \Carbon\Carbon::parse($sprint->end_date)->format('d/m') : 'N/D' }})
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_sprints_for_quarter') }}</p> {{-- Chave nova: sgb.no_sprints_for_quarter --}}
            </div>
        @endif
    </div>


    {{-- Botões de Ação do Período --}}
    <div class="mt-8 flex items-center justify-start space-x-3">
        <a href="{{ route('quarters.edit', $quarter) }}"
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
           {{ __('sgb.edit_quarter') }}
        </a>
        <a href="{{ route('quarters.index') }}"
           class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
           {{ __('sgb.back_to_list') }}
        </a>
        <form action="{{ route('quarters.destroy', $quarter) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message') }} {{-- Considere uma mensagem mais específica se houver restrições --}}');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.delete_quarter') }} {{-- Chave nova: sgb.delete_quarter --}}
            </button>
        </form>
    </div>

@endsection