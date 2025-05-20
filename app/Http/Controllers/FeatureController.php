<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\MainObjective; // Para carregar Objetivos Principais nos formulários
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Para regras de validação ENUM

class FeatureController extends Controller
{
    /**
     * Construtor para aplicar middleware, se necessário.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('can:manage-features')->except(['index', 'show']); // Exemplo
    }

    /**
     * Exibe uma lista das funcionalidades.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // Permitir filtrar features por objective_id se passado via query string
        $query = Feature::with('mainObjective')->orderBy('created_at', 'desc');

        if ($request->has('objective_id')) {
            $query->where('objective_id', $request->input('objective_id'));
        }

        $features = $query->paginate(10);
        
        // Opcional: Carregar o objetivo principal se estivermos filtrando por ele, para exibir o título
        $mainObjective = null;
        if ($request->has('objective_id')) {
            $mainObjective = MainObjective::find($request->input('objective_id'));
        }

        return view('features.index', compact('features', 'mainObjective'));
        // Você precisará criar a view: resources/views/features/index.blade.php
    }

    /**
     * Mostra o formulário para criar uma nova funcionalidade.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        $mainObjectives = MainObjective::orderBy('title')->get();
        $statuses = ['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído']; // Valores do ENUM
        
        // Para pré-selecionar o objetivo se viemos do link "Nova Funcionalidade para este Objetivo"
        $selectedObjectiveId = $request->query('objective_id');

        return view('features.create', compact('mainObjectives', 'statuses', 'selectedObjectiveId'));
        // Você precisará criar a view: resources/views/features/create.blade.php
    }

    /**
     * Armazena uma nova funcionalidade no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request StoreFeatureRequest
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective_id' => 'required|exists:main_objectives,id', // Funcionalidade deve pertencer a um objetivo
            'status' => [
                'required',
                Rule::in(['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído']),
            ],
        ]);

        try {
            Feature::create($validatedData);
            return redirect()->route('features.index', ['objective_id' => $validatedData['objective_id']]) // Redireciona para a lista de features do objetivo
                             ->with('success', 'Funcionalidade criada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Feature: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao criar a Funcionalidade. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Exibe os detalhes de uma funcionalidade específica.
     *
     * @param  \App\Models\Feature  $feature  // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(Feature $feature): View
    {
        $feature->load(['mainObjective', 'tasks']); // Carrega o objetivo pai e as tarefas filhas
        return view('features.show', compact('feature'));
        // Você precisará criar a view: resources/views/features/show.blade.php
    }

    /**
     * Mostra o formulário para editar uma funcionalidade existente.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\View\View
     */
    public function edit(Feature $feature): View
    {
        $mainObjectives = MainObjective::orderBy('title')->get();
        $statuses = ['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído'];

        return view('features.edit', compact('feature', 'mainObjectives', 'statuses'));
        // Você precisará criar a view: resources/views/features/edit.blade.php
    }

    /**
     * Atualiza uma funcionalidade específica no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Feature $feature): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request UpdateFeatureRequest
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective_id' => 'required|exists:main_objectives,id',
            'status' => [
                'required',
                Rule::in(['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído']),
            ],
        ]);

        try {
            $feature->update($validatedData);
            return redirect()->route('features.index', ['objective_id' => $feature->objective_id]) // Redireciona para a lista de features do objetivo
                             ->with('success', 'Funcionalidade atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar Feature ID ' . $feature->id . ': ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar a Funcionalidade. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Remove uma funcionalidade específica do banco de dados.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        try {
            $objectiveId = $feature->objective_id; // Guardar o ID do objetivo para redirecionamento
            // A constraint da FK em `tasks` para `features` é ON DELETE CASCADE.
            // Todas as tarefas associadas serão excluídas automaticamente.
            $tasksCount = $feature->tasks()->count();
            $feature->delete();

            $message = 'Funcionalidade excluída com sucesso!';
            if ($tasksCount > 0) {
                $message .= " $tasksCount tarefa(s) associada(s) também foram excluídas.";
            }

            return redirect()->route('features.index', ['objective_id' => $objectiveId]) // Redireciona para a lista de features do objetivo
                             ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir Feature ID ' . $feature->id . ': ' . $e->getMessage());
            return redirect()->route('features.index')
                             ->with('error', 'Erro ao excluir a Funcionalidade. Tente novamente.');
        }
    }
}