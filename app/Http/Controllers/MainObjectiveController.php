<?php

namespace App\Http\Controllers;

use App\Models\MainObjective;
use App\Models\Quarter; // Para carregar Quarters nos formulários
use App\Models\User;    // Para carregar Usuários (responsáveis) nos formulários
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Para regras de validação ENUM

class MainObjectiveController extends Controller
{
    /**
     * Construtor para aplicar middleware, se necessário.
     * Exemplo: proteger todas as rotas deste controller com autenticação.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('can:manage-objectives')->except(['index', 'show']); // Exemplo com Gate/Policy
    }

    /**
     * Exibe uma lista dos objetivos principais.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $mainObjectives = MainObjective::with(['quarter', 'responsibleUser']) // Eager load para performance
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(10);
        return view('main_objectives.index', compact('mainObjectives'));
        // Você precisará criar a view: resources/views/main_objectives/index.blade.php
    }

    /**
     * Mostra o formulário para criar um novo objetivo principal.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $quarters = Quarter::orderBy('name')->get();
        $users = User::orderBy('name')->get(); // Assumindo que todos os usuários podem ser responsáveis
        $statuses = ['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído', 'Aguardando Início']; // Valores do ENUM

        return view('main_objectives.create', compact('quarters', 'users', 'statuses'));
        // Você precisará criar a view: resources/views/main_objectives/create.blade.php
    }

    /**
     * Armazena um novo objetivo principal no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request StoreMainObjectiveRequest
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quarter_id' => 'nullable|exists:quarters,id',
            'responsible_user_id' => 'nullable|exists:users,id',
            'status' => [
                'required',
                Rule::in(['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído', 'Aguardando Início']),
            ],
            'notes' => 'nullable|string',
        ]);

        try {
            MainObjective::create($validatedData);
            return redirect()->route('main-objectives.index')
                             ->with('success', 'Objetivo Principal criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar MainObjective: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao criar o Objetivo Principal. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Exibe os detalhes de um objetivo principal específico.
     *
     * @param  \App\Models\MainObjective  $mainObjective  // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(MainObjective $mainObjective): View
    {
        // Carregar relacionamentos se for exibi-los na view show
        $mainObjective->load(['quarter', 'responsibleUser', 'features']);
        return view('main_objectives.show', compact('mainObjective'));
        // Você precisará criar a view: resources/views/main_objectives/show.blade.php
    }

    /**
     * Mostra o formulário para editar um objetivo principal existente.
     *
     * @param  \App\Models\MainObjective  $mainObjective
     * @return \Illuminate\View\View
     */
    public function edit(MainObjective $mainObjective): View
    {
        $quarters = Quarter::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $statuses = ['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído', 'Aguardando Início'];

        return view('main_objectives.edit', compact('mainObjective', 'quarters', 'users', 'statuses'));
        // Você precisará criar a view: resources/views/main_objectives/edit.blade.php
    }

    /**
     * Atualiza um objetivo principal específico no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MainObjective  $mainObjective
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, MainObjective $mainObjective): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request UpdateMainObjectiveRequest
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quarter_id' => 'nullable|exists:quarters,id',
            'responsible_user_id' => 'nullable|exists:users,id',
            'status' => [
                'required',
                Rule::in(['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído', 'Aguardando Início']),
            ],
            'notes' => 'nullable|string',
        ]);

        try {
            $mainObjective->update($validatedData);
            return redirect()->route('main-objectives.index')
                             ->with('success', 'Objetivo Principal atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar MainObjective ID ' . $mainObjective->id . ': ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar o Objetivo Principal. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Remove um objetivo principal específico do banco de dados.
     *
     * @param  \App\Models\MainObjective  $mainObjective
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MainObjective $mainObjective): RedirectResponse
    {
        try {
            // A constraint da FK em `features` para `main_objectives` é ON DELETE CASCADE.
            // Isso significa que todas as features associadas serão excluídas automaticamente.
            // É bom estar ciente disso e, se necessário, adicionar uma confirmação mais explícita ao usuário.
            $featuresCount = $mainObjective->features()->count();
            $mainObjective->delete();

            $message = 'Objetivo Principal excluído com sucesso!';
            if ($featuresCount > 0) {
                $message .= " $featuresCount funcionalidade(s) associada(s) também foram excluídas.";
            }

            return redirect()->route('main-objectives.index')
                             ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir MainObjective ID ' . $mainObjective->id . ': ' . $e->getMessage());
            return redirect()->route('main-objectives.index')
                             ->with('error', 'Erro ao excluir o Objetivo Principal. Tente novamente.');
        }
    }
}