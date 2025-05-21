{{-- resources/views/layouts/partials/sidebar.blade.php --}}
<aside class="w-64 bg-gray-800 text-gray-100 p-6 space-y-6 hidden md:flex md:flex-col md:fixed md:h-full">
    {{-- Logo ou Nome do Projeto --}}
    <div class="text-center mb-4">
        <a href="{{ route('dashboard') }}" class="text-2xl font-semibold text-white hover:text-gray-300">
            SGB
        </a>
    </div>

    <nav class="flex-grow">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    {{-- Adicione um ícone SVG aqui se desejar --}}
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('quarters.index') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('quarters.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <span class="ml-3">Trimestres/Semestres</span>
                </a>
            </li>
            <li>
                <a href="{{ route('main-objectives.index') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('main-objectives.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <span class="ml-3">Objetivos Principais</span>
                </a>
            </li>
            <li>
                <a href="{{ route('features.index') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('features.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <span class="ml-3">Funcionalidades</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tasks.index') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('tasks.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <span class="ml-3">Tarefas</span>
                </a>
            </li>

            {{-- Divisor --}}
            <li class="pt-2">
                <span class="px-4 text-xs font-semibold uppercase text-gray-500">Configurações</span>
            </li>

            <li>
                <a href="{{ route('systems.index') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('systems.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <span class="ml-3">Sistemas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('modules.index') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('modules.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <span class="ml-3">Módulos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sprints.index') }}"
                   class="flex items-center px-4 py-2.5 rounded-md transition duration-200 ease-in-out
                          {{ request()->routeIs('sprints.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <span class="ml-3">Sprints</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- Espaço para logout ou informações do usuário na sidebar, se desejar --}}
    <div class="mt-auto">
        {{-- Pode adicionar algo aqui se quiser, como um link rápido para o perfil --}}
    </div>
</aside>