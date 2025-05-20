<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\Quarter; // Para carregar Quarters nos formulários
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SprintController extends Controller
{
    /**
     * Construtor para aplicar middleware, se necessário.
     * Ex: apenas administradores podem gerenciar Sprints.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin'); // Exemplo
    }

    /**
     * Exibe uma lista das sprints.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Sprint::with('quarter')
                       ->withCount(['startTasks', 'deliveryTasks']) // Otimização para contagem na view
                       ->orderBy('start_date', 'desc')
                       ->orderBy('name', 'asc');

        if ($request->has('quarter_id')) {
            $query->where('quarter_id', $request->input('quarter_id'));
        }

        $sprints = $query->paginate(15);

        $quarter = null;
        if ($request->has('quarter_id')) {
            $quarter = Quarter::find($request->input('quarter_id'));
        }

        return view('sprints.index', compact('sprints', 'quarter'));
        // View criada na etapa anterior: resources/views/sprints/index.blade.php
    }

    /**
     * Mostra o formulário para criar uma nova sprint.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        $quarters = Quarter::orderBy('name')->get();
        $selectedQuarterId = $request->query('quarter_id'); // Para pré-selecionar

        return view('sprints.create', compact('quarters', 'selectedQuarterId'));
        // View criada na etapa anterior: resources/views/sprints/create.blade.php
    }

    /**
     * Armazena uma nova sprint no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request StoreSprintRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:sprints,name',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quarter_id' => 'nullable|exists:quarters,id',
        ]);

        try {
            Sprint::create($validatedData);
            $redirectParams = $validatedData['quarter_id'] ? ['quarter_id' => $validatedData['quarter_id']] : [];
            return redirect()->route('sprints.index', $redirectParams)
                             ->with('success', 'Sprint criada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Sprint: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao criar a Sprint. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Exibe os detalhes de uma sprint específica.
     *
     * @param  \App\Models\Sprint  $sprint  // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(Sprint $sprint): View
    {
        $sprint->load(['quarter', 'startTasks', 'deliveryTasks']); // Carrega os relacionamentos
        return view('sprints.show', compact('sprint'));
        // View criada na etapa anterior: resources/views/sprints/show.blade.php
    }

    /**
     * Mostra o formulário para editar uma sprint existente.
     *
     * @param  \App\Models\Sprint  $sprint
     * @return \Illuminate\View\View
     */
    public function edit(Sprint $sprint): View
    {
        $quarters = Quarter::orderBy('name')->get();
        return view('sprints.edit', compact('sprint', 'quarters'));
        // View criada na etapa anterior: resources/views/sprints/edit.blade.php
    }

    /**
     * Atualiza uma sprint específica no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sprint  $sprint
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Sprint $sprint): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request UpdateSprintRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:sprints,name,' . $sprint->id,
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quarter_id' => 'nullable|exists:quarters,id',
        ]);

        try {
            $sprint->update($validatedData);
            $redirectParams = $sprint->quarter_id ? ['quarter_id' => $sprint->quarter_id] : [];
            return redirect()->route('sprints.index', $redirectParams)
                             ->with('success', 'Sprint atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar Sprint ID ' . $sprint->id . ': ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar a Sprint. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Remove uma sprint específica do banco de dados.
     *
     * @param  \App\Models\Sprint  $sprint
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Sprint $sprint): RedirectResponse
    {
        try {
            $quarterId = $sprint->quarter_id; // Guardar o ID do quarter para redirecionamento

            // De acordo com as migrations, as FKs 'start_sprint_id' e 'delivery_sprint_id'
            // na tabela 'tasks' foram definidas com ON DELETE SET NULL.
            // As tarefas associadas terão esses campos definidos como NULL.
            $startTasksCount = $sprint->startTasks()->count();
            $deliveryTasksCount = $sprint->deliveryTasks()->count();

            $sprint->delete();

            $message = 'Sprint excluída com sucesso!';
            if ($startTasksCount > 0 || $deliveryTasksCount > 0) {
                $message .= " As tarefas anteriormente associadas a esta sprint (início ou entrega) não foram excluídas, mas foram desvinculadas.";
            }
            
            $redirectParams = $quarterId ? ['quarter_id' => $quarterId] : [];
            return redirect()->route('sprints.index', $redirectParams)
                             ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir Sprint ID ' . $sprint->id . ': ' . $e->getMessage());
            return redirect()->route('sprints.index')
                             ->with('error', 'Erro ao excluir a Sprint. Tente novamente.');
        }
    }
}