<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'SGB'))</title> {{-- Modificado para usar yield e o nome do app --}}

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])        

        {{-- Seus estilos CSS customizados para o SGB (se não migrou tudo para Tailwind) --}}
        <style>
            /* Estilos básicos para botões, tabelas, alertas, formulários do SGB */
            /* Se você está usando Tailwind extensivamente, pode remover/substituir estes por classes Tailwind */
            .sgb-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            .sgb-table th, .sgb-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            .sgb-table th { background-color: #e9ecef; color: #cbcccd; }

            .sgb-btn { padding: 10px 18px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 8px; margin-right: 8px; border: none; cursor: pointer; font-size: 0.95em; transition: background-color 0.2s; }
            .sgb-btn-primary { background-color: #3498db; color: white; }
            .sgb-btn-primary:hover { background-color: #2980b9; }
            .sgb-btn-secondary { background-color: #7f8c8d; color: white; }
            .sgb-btn-secondary:hover { background-color: #6c7a7b; }
            /* Adicione mais estilos .sgb-* conforme necessário para evitar conflitos com Tailwind, se mantiver CSS customizado */

            .sgb-alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
            .sgb-alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
            .sgb-alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }

            .sgb-form-group { margin-bottom: 18px; }
            .sgb-form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #495057; }
            .sgb-form-group input[type="text"], .sgb-form-group input[type="date"], .sgb-form-group input[type="number"], .sgb-form-group input[type="url"], .sgb-form-group textarea, .sgb-form-group select { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; font-size: 0.95em; }
            .sgb-form-group input[type="text"]:focus, .sgb-form-group input[type="date"]:focus, .sgb-form-group input[type="number"]:focus, .sgb-form-group input[type="url"]:focus, .sgb-form-group textarea:focus, .sgb-form-group select:focus { border-color: #80bdff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
            .sgb-form-group .invalid-feedback { color: #e74c3c; font-size: 0.875em; margin-top: 4px; }

            .sgb-card { background-color: #fff; border: 1px solid #e3e6f0; border-radius: .35rem; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); margin-bottom: 1.5rem; }
            .sgb-card-header { padding: .75rem 1.25rem; margin-bottom: 0; background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: bold; color: #3498db; }
            .sgb-card-body { padding: 1.25rem; }
            .sgb-grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }

            /* Ajuste para conteúdo principal quando a sidebar está presente em telas médias e grandes */
            @media (min-width: 768px) { /* md breakpoint do Tailwind */
                .main-content-with-sidebar {
                    margin-left: 16rem; /* Largura da sidebar (w-64 = 16rem) */
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="flex h-screen">
            {{-- Nossa Sidebar --}}
            @include('layouts.partials.sidebar')

            {{-- Conteúdo Principal, incluindo a navegação superior do Breeze --}}
            <div class="flex-1 flex flex-col overflow-hidden">
                @include('layouts.navigation') {{-- Navegação superior do Breeze --}}               

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
                    <div class="main-content-with-sidebar py-6 px-4 sm:px-6 lg:px-8"> {{-- Conteúdo principal com margem para sidebar --}}
                         {{-- Mensagens Flash --}}
                        @if (session('success'))
                            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                             <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @hasSection ('content') {{-- Verifica se a seção content existe --}}
                            @yield('content')
                        @else
                            {{ $slot ?? '' }} {{-- Padrão do Breeze se usar $slot --}}
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>