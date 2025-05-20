@extends('layouts.app')

@section('title', 'Dashboard - SGB')

@section('content')
    <h2>Dashboard</h2>

    <p>Bem-vindo(a) ao Sistema Gerenciador de Backlog!</p>

    <div class="grid-container" style="margin-top: 25px; margin-bottom: 25px;">
        <div class="card">
            <div class="card-header">Objetivos Principais</div>
            <div class="card-body">
                <p>Total: {{ $stats['totalObjectives'] }}</p>
                <p>Em Andamento: {{ $stats['objectivesInProgress'] }}</p>
                <a href="{{ route('main-objectives.index') }}" class="btn btn-sm btn-primary">Ver Objetivos</a>
                <a href="{{ route('main-objectives.create') }}" class="btn btn-sm btn-secondary">Novo Objetivo</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Funcionalidades</div>
            <div class="card-body">
                <p>Total: {{ $stats['totalFeatures'] }}</p>
                {{-- Adicione mais estatísticas de funcionalidades aqui --}}
                <a href="{{ route('features.index') }}" class="btn btn-sm btn-primary">Ver Funcionalidades</a>
                <a href="{{ route('features.create') }}" class="btn btn-sm btn-secondary">Nova Funcionalidade</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Tarefas</div>
            <div class="card-body">
                <p>Pendentes/Em Andamento: {{ $stats['pendingTasks'] }}</p>
                <p>Concluídas Hoje: {{ $stats['completedTasksToday'] }}</p>
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-primary">Ver Tarefas</a>
                <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-secondary">Nova Tarefa</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Configurações Gerais</div>
            <div class="card-body">
                <p>Gerencie os dados base do sistema.</p>
                <a href="{{ route('quarters.index') }}" class="btn btn-sm btn-secondary">Trimestres/Semestres</a>
                <a href="{{ route('sprints.index') }}" class="btn btn-sm btn-secondary">Sprints</a>
                <a href="{{ route('systems.index') }}" class="btn btn-sm btn-secondary">Sistemas</a>
                <a href="{{ route('modules.index') }}" class="btn btn-sm btn-secondary">Módulos</a>
            </div>
        </div>
    </div>

    {{-- Você pode adicionar mais seções aqui, como: --}}
    {{-- - Tarefas recentes atribuídas a você --}}
    {{-- - Gráficos de progresso (usando bibliotecas como Chart.js) --}}
    {{-- - Linha do tempo de atividades --}}

@endsection