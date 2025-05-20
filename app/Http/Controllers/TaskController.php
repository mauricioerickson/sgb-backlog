<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Feature;
use App\Models\System;
use App\Models\Module;
use App\Models\Sprint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    // Constantes para ENUMs para fácil referência e consistência
    const TASK_TYPES = ['Bug', 'Melhoria', 'Nova Funcionalidade', 'Débito Técnico', 'Pesquisa'];
    const PRIORITIES = ['Baixa', 'Média', 'Alta', 'Crítica'];
    const STATUSES = ['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído', 'Em Testes', 'Bloqueada', 'Cancelada'];

    /**
     * Construtor para aplicar middleware.
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Exibe uma lista das tarefas.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Task::with([
            'feature.mainObjective', // Para mostrar o objetivo da feature
            'system',
            'module',
            'assignee',
            'requester',
            'startSprint',
            'deliverySprint'
        ])->orderBy('created_at', 'desc');

        // Exemplos de Filtros (podem ser expandidos ou movidos para Query Scopes/Filtros dedicados)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('assignee_user_id')) {
            $query->where('assignee_user_id', $request->assignee_user_id);
        }
        if ($request->filled('feature_id')) {
            $query->where('feature_id', $request->feature_id);
        }
        // Adicionar mais filtros conforme necessário (system, module, sprint, etc.)

        $tasks = $query->paginate(15)->appends($request->query());

        // Dados para os selects de filtro na view index
        $users = User::orderBy('name')->get();
        $features = Feature::orderBy('title')->get();
        $statuses = self::STATUSES;
        $priorities = self::PRIORITIES;


        return view('tasks.index', compact('tasks', 'users', 'features', 'statuses', 'priorities'));
        // View: resources/views/tasks/index.blade.php
    }

    /**
     * Mostra o formulário para criar uma nova tarefa.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        $features = Feature::orderBy('title')->get();
        $systems = System::orderBy('name')->get();
        $modules = Module::orderBy('name')->get(); // Idealmente, filtrar por sistema via JS no frontend
        $sprints = Sprint::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        $taskTypes = self::TASK_TYPES;
        $priorities = self::PRIORITIES;
        $statuses = self::STATUSES;

        // Para pré-selecionar campos se vier de links específicos
        $selectedFeatureId = $request->query('feature_id');
        $selectedModuleId = $request->query('module_id');
        $selectedStartSprintId = $request->query('start_sprint_id');
        // Adicione outros conforme necessário

        return view('tasks.create', compact(
            'features', 'systems', 'modules', 'sprints', 'users',
            'taskTypes', 'priorities', 'statuses',
            'selectedFeatureId', 'selectedModuleId', 'selectedStartSprintId'
        ));
        // View: resources/views/tasks/create.blade.php
    }

    /**
     * Armazena uma nova tarefa no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // ALTAMENTE RECOMENDADO: Usar Form Request (php artisan make:request StoreTaskRequest)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'feature_id' => 'nullable|exists:features,id',
            'system_id' => 'nullable|exists:systems,id',
            'module_id' => 'nullable|exists:modules,id', // Adicionar validação de que o módulo pertence ao sistema, se aplicável
            'estimated_hours' => 'nullable|numeric|min:0|max:9999.99',
            'task_type' => ['required', Rule::in(self::TASK_TYPES)],
            'priority' => ['required', Rule::in(self::PRIORITIES)],
            'start_sprint_id' => 'nullable|exists:sprints,id',
            'delivery_sprint_id' => 'nullable|exists:sprints,id', // Poderia validar se delivery_sprint é após start_sprint
            'status' => ['required', Rule::in(self::STATUSES)],
            'requester_user_id' => 'nullable|exists:users,id',
            'assignee_user_id' => 'nullable|exists:users,id',
            'helpdesk_link' => 'nullable|url|max:255',
            'notes' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        try {
            // Se não houver um solicitante, pode-se atribuir o usuário logado
            // if (empty($validatedData['requester_user_id']) && auth()->check()) {
            //     $validatedData['requester_user_id'] = auth()->id();
            // }

            Task::create($validatedData);
            return redirect()->route('tasks.index')
                             ->with('success', 'Tarefa criada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Tarefa: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao criar a Tarefa. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Exibe os detalhes de uma tarefa específica.
     *
     * @param  \App\Models\Task  $task  // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(Task $task): View
    {
        $task->load([
            'feature.mainObjective',
            'system',
            'module',
            'assignee',
            'requester',
            'startSprint.quarter', // Para mostrar o quarter da sprint
            'deliverySprint.quarter',
            'comments.author' // Carrega comentários e seus autores
        ]);
        return view('tasks.show', compact('task'));
        // View: resources/views/tasks/show.blade.php
    }

    /**
     * Mostra o formulário para editar uma tarefa existente.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function edit(Task $task): View
    {
        $features = Feature::orderBy('title')->get();
        $systems = System::orderBy('name')->get();
        $modules = Module::orderBy('name')->get(); // Idealmente, filtrar por sistema via JS no frontend
        $sprints = Sprint::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        $taskTypes = self::TASK_TYPES;
        $priorities = self::PRIORITIES;
        $statuses = self::STATUSES;

        return view('tasks.edit', compact(
            'task', 'features', 'systems', 'modules', 'sprints', 'users',
            'taskTypes', 'priorities', 'statuses'
        ));
        // View: resources/views/tasks/edit.blade.php
    }

    /**
     * Atualiza uma tarefa específica no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        // ALTAMENTE RECOMENDADO: Usar Form Request (php artisan make:request UpdateTaskRequest)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'feature_id' => 'nullable|exists:features,id',
            'system_id' => 'nullable|exists:systems,id',
            'module_id' => 'nullable|exists:modules,id', // Adicionar validação de que o módulo pertence ao sistema, se aplicável
            'estimated_hours' => 'nullable|numeric|min:0|max:9999.99',
            'task_type' => ['required', Rule::in(self::TASK_TYPES)],
            'priority' => ['required', Rule::in(self::PRIORITIES)],
            'start_sprint_id' => 'nullable|exists:sprints,id',
            'delivery_sprint_id' => 'nullable|exists:sprints,id',
            'status' => ['required', Rule::in(self::STATUSES)],
            'requester_user_id' => 'nullable|exists:users,id',
            'assignee_user_id' => 'nullable|exists:users,id',
            'helpdesk_link' => 'nullable|url|max:255',
            'notes' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        try {
            $task->update($validatedData);
            return redirect()->route('tasks.show', $task) // Ou tasks.index
                             ->with('success', 'Tarefa atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar Tarefa ID ' . $task->id . ': ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar a Tarefa. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Remove uma tarefa específica do banco de dados.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        try {
            // A FK em 'task_comments' para 'tasks' é ON DELETE CASCADE.
            // Comentários associados serão excluídos automaticamente.
            $task->delete();
            return redirect()->route('tasks.index')
                             ->with('success', 'Tarefa excluída com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir Tarefa ID ' . $task->id . ': ' . $e->getMessage());
            return redirect()->route('tasks.index')
                             ->with('error', 'Erro ao excluir a Tarefa. Tente novamente.');
        }
    }
}