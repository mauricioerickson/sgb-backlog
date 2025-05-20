<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SGB - Gerenciador de Backlog')</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f0f2f5; color: #333; display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background-color: #2c3e50; color: #ecf0f1; padding: 20px; display: flex; flex-direction: column; }
        .sidebar h1 { font-size: 1.5em; margin: 0 0 20px 0; text-align: center; color: #fff; }
        .sidebar nav ul { list-style-type: none; padding: 0; margin: 0; }
        .sidebar nav ul li a { display: block; color: #bdc3c7; text-decoration: none; padding: 10px 15px; border-radius: 4px; margin-bottom: 5px; transition: background-color 0.3s, color 0.3s; }
        .sidebar nav ul li a:hover, .sidebar nav ul li a.active { background-color: #3498db; color: #fff; }
        .main-content { flex-grow: 1; padding: 20px; overflow-y: auto; }
        .container { max-width: 1200px; margin: auto; background-color: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-top:0; }
        /* Estilos para botões, tabelas, alertas, formulários (mantidos do exemplo anterior) */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #e9ecef; color: #495057; }
        .btn { padding: 10px 18px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 8px; margin-right: 8px; border: none; cursor: pointer; font-size: 0.95em; transition: background-color 0.2s; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }
        .btn-secondary { background-color: #7f8c8d; color: white; }
        .btn-secondary:hover { background-color: #6c7a7b; }
        .btn-warning { background-color: #f39c12; color: white; }
        .btn-warning:hover { background-color: #e67e22; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-danger:hover { background-color: #c0392b; }
        .btn-sm { padding: 5px 10px; font-size: 0.85em; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #495057; }
        .form-group input[type="text"], .form-group input[type="date"], .form-group input[type="number"], .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; font-size: 0.95em; }
        .form-group input[type="text"]:focus, .form-group input[type="date"]:focus, .form-group input[type="number"]:focus, .form-group textarea:focus, .form-group select:focus { border-color: #80bdff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
        .form-group .invalid-feedback { color: #e74c3c; font-size: 0.875em; margin-top: 4px; }
        .card { background-color: #fff; border: 1px solid #e3e6f0; border-radius: .35rem; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); margin-bottom: 1.5rem; }
        .card-header { padding: .75rem 1.25rem; margin-bottom: 0; background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: bold; color: #3498db; }
        .card-body { padding: 1.25rem; }
        .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h1>SGB</h1>
        <nav>
            <ul>
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('quarters.index') }}" class="{{ request()->routeIs('quarters.*') ? 'active' : '' }}">Trimestres/Semestres</a></li>
                <li><a href="{{ route('main-objectives.index') }}" class="{{ request()->routeIs('main-objectives.*') ? 'active' : '' }}">Objetivos Principais</a></li>
                <li><a href="{{ route('features.index') }}" class="{{ request()->routeIs('features.*') ? 'active' : '' }}">Funcionalidades</a></li>
                <li><a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">Tarefas</a></li>
                <hr style="border-color: #34495e; margin: 15px 0;">
                <li><a href="{{ route('systems.index') }}" class="{{ request()->routeIs('systems.*') ? 'active' : '' }}">Sistemas</a></li>
                <li><a href="{{ route('modules.index') }}" class="{{ request()->routeIs('modules.*') ? 'active' : '' }}">Módulos</a></li>
                <li><a href="{{ route('sprints.index') }}" class="{{ request()->routeIs('sprints.*') ? 'active' : '' }}">Sprints</a></li>
                {{-- Futuros links de admin/configurações --}}
                {{--
                @auth
                <hr style="border-color: #34495e; margin: 15px 0;">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="background-color: transparent; padding-left:15px;">Sair</a>
                    </form>
                </li>
                @endauth
                --}}
            </ul>
        </nav>
    </aside>

    <div class="main-content">
        <div class="container">
            {{-- Mensagens Flash --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

            <footer style="margin-top: 30px; text-align: center; font-size: 0.9em; color: #777; padding-top: 20px; border-top: 1px solid #eee;">
                <p>&copy; {{ date('Y') }} SGB. Todos os direitos reservados. (20 de Maio de 2025)</p>
            </footer>
        </div>
    </div>

    </body>
</html>