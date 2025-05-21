<x-app-layout> {{-- Usa o componente de layout app do Breeze --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Container padrão do Breeze para conteúdo --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Bem-vindo(a) ao Sistema Gerenciador de Backlog!</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Card Objetivos --}}
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-blue-600 dark:text-blue-400">Objetivos Principais</h4>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Total: {{ $stats['totalObjectives'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Em Andamento: {{ $stats['objectivesInProgress'] ?? 0 }}</p>
                            <div class="mt-4">
                                <a href="{{ route('main-objectives.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Ver Objetivos</a>
                                <a href="{{ route('main-objectives.create') }}" class="ml-4 text-sm font-medium text-green-600 dark:text-green-400 hover:underline">Novo Objetivo</a>
                            </div>
                        </div>

                        {{-- Card Funcionalidades --}}
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-purple-600 dark:text-purple-400">Funcionalidades</h4>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Total: {{ $stats['totalFeatures'] ?? 0 }}</p>
                            <div class="mt-4">
                                <a href="{{ route('features.index') }}" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline">Ver Funcionalidades</a>
                                <a href="{{ route('features.create') }}" class="ml-4 text-sm font-medium text-green-600 dark:text-green-400 hover:underline">Nova Funcionalidade</a>
                            </div>
                        </div>

                        {{-- Card Tarefas --}}
                        <div class="bg-gray-50 dark:bg-g\ray-700 p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-teal-600 dark:text-teal-400">Tarefas</h4>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Pendentes/Em Andamento: {{ $stats['pendingTasks'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Concluídas Hoje: {{ $stats['completedTasksToday'] ?? 0 }}</p>
                            <div class="mt-4">
                                <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-teal-600 dark:text-teal-400 hover:underline">Ver Tarefas</a>
                                <a href="{{ route('tasks.create') }}" class="ml-4 text-sm font-medium text-green-600 dark:text-green-400 hover:underline">Nova Tarefa</a>
                            </div>
                        </div>
                         {{-- Card Configurações --}}
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow md:col-span-1">
                            <h4 class="font-semibold text-indigo-600 dark:text-indigo-400">Configurações Gerais</h4>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Gerencie os dados base do sistema.</p>
                            <div class="mt-4 space-y-2">
                                <a href="{{ route('quarters.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Trimestres/Semestres</a>
                                <a href="{{ route('sprints.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sprints</a>
                                <a href="{{ route('systems.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sistemas</a>
                                <a href="{{ route('modules.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Módulos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>