<x-app-layout> {{-- Usa o componente de layout app do Breeze --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('sgb.dashboard') }} {{-- Usando nossa chave sgb.dashboard --}}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Container padrão do Breeze para conteúdo --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-medium mb-6">{{ __('sgb.welcome_dashboard') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Card Objetivos --}}
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-semibold text-blue-600 dark:text-blue-400">{{ __('sgb.main_objectives') }}</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ __('sgb.total_objectives') }}: {{ $stats['totalObjectives'] ?? 0 }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('sgb.objectives_in_progress') }}: {{ $stats['objectivesInProgress'] ?? 0 }}</p>
                        <div class="mt-4">
                            <a href="{{ route('main-objectives.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('sgb.view') }} {{ strtolower(__('sgb.main_objectives')) }}</a>
                            <a href="{{ route('main-objectives.create') }}" class="ml-4 text-sm font-medium text-green-600 dark:text-green-400 hover:underline">{{ __('sgb.new_main_objective') }}</a>
                        </div>
                    </div>

                    {{-- Card Funcionalidades --}}
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-semibold text-purple-600 dark:text-purple-400">{{ __('sgb.features') }}</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ __('sgb.total_features') }}: {{ $stats['totalFeatures'] ?? 0 }}</p>
                        <div class="mt-4">
                            <a href="{{ route('features.index') }}" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline">{{ __('sgb.view') }} {{ strtolower(__('sgb.features')) }}</a>
                            <a href="{{ route('features.create') }}" class="ml-4 text-sm font-medium text-green-600 dark:text-green-400 hover:underline">{{ __('sgb.new_feature') }}</a>
                        </div>
                    </div>

                    {{-- Card Tarefas --}}
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-semibold text-teal-600 dark:text-teal-400">{{ __('sgb.tasks') }}</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ __('sgb.pending_tasks') }}: {{ $stats['pendingTasks'] ?? 0 }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('sgb.completed_tasks_today') }}: {{ $stats['completedTasksToday'] ?? 0 }}</p>
                        <div class="mt-4">
                            <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-teal-600 dark:text-teal-400 hover:underline">{{ __('sgb.view') }} {{ strtolower(__('sgb.tasks')) }}</a>
                            <a href="{{ route('tasks.create') }}" class="ml-4 text-sm font-medium text-green-600 dark:text-green-400 hover:underline">{{ __('sgb.new_task') }}</a>
                        </div>
                    </div>

                        {{-- Card Configurações --}}
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow md:col-span-1 lg:col-span-1"> {{-- Ajustado para ocupar melhor o espaço em diferentes telas --}}
                        <h4 class="font-semibold text-indigo-600 dark:text-indigo-400">{{ __('sgb.general_settings') }}</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ __('sgb.manage_base_data') }}</p>
                        <div class="mt-4 space-y-2">
                            <a href="{{ route('quarters.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sgb.quarters') }}</a>
                            <a href="{{ route('sprints.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sgb.sprints') }}</a>
                            <a href="{{ route('systems.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sgb.systems') }}</a>
                            <a href="{{ route('modules.index') }}" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sgb.modules') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>