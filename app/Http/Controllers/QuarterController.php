<?php

namespace App\Http\Controllers;

use App\Models\Quarter;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuarterController extends Controller
{
    /**
     * Construtor para aplicar middleware, se necessário.
     * Exemplo: proteger todas as rotas deste controller com autenticação.
     * Se apenas administradores puderem gerenciar Quarters, adicione um middleware de admin aqui.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin')->except(['index', 'show']); // Exemplo de middleware de admin
    }

    /**
     * Exibe uma lista dos quarters (trimestres/semestres).
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $quarters = Quarter::orderBy('start_date', 'desc')->paginate(10); // Ordena pelos mais recentes e pagina
        return view('quarters.index', compact('quarters'));
        // Você precisará criar a view: resources/views/quarters/index.blade.php
    }

    /**
     * Mostra o formulário para criar um novo quarter.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('quarters.create');
        // Você precisará criar a view: resources/views/quarters/create.blade.php
    }

    /**
     * Armazena um novo quarter no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validação dos dados
        // Para validações mais complexas ou reutilizáveis, considere criar um Form Request:
        // php artisan make:request StoreQuarterRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:quarters,name',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            Quarter::create($validatedData);
            return redirect()->route('quarters.index')
                             ->with('success', 'Trimestre/Semestre criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Quarter: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao criar o trimestre/semestre. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Exibe os detalhes de um quarter específico.
     * (Este método pode não ser muito utilizado para Quarters, mas é padrão de resource)
     *
     * @param  \App\Models\Quarter  $quarter
     * @return \Illuminate\View\View
     */
    public function show(Quarter $quarter): View
    {
        return view('quarters.show', compact('quarter'));
        // Você precisará criar a view: resources/views/quarters/show.blade.php
    }

    /**
     * Mostra o formulário para editar um quarter existente.
     *
     * @param  \App\Models\Quarter  $quarter
     * @return \Illuminate\View\View
     */
    public function edit(Quarter $quarter): View
    {
        return view('quarters.edit', compact('quarter'));
        // Você precisará criar a view: resources/views/quarters/edit.blade.php
    }

    /**
     * Atualiza um quarter específico no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quarter  $quarter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Quarter $quarter): RedirectResponse
    {
        // Validação dos dados
        // Para validações mais complexas ou reutilizáveis, considere criar um Form Request:
        // php artisan make:request UpdateQuarterRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:quarters,name,' . $quarter->id, // Ignora o ID atual na verificação de unicidade
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            $quarter->update($validatedData);
            return redirect()->route('quarters.index')
                             ->with('success', 'Trimestre/Semestre atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar Quarter ID ' . $quarter->id . ': ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar o trimestre/semestre. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Remove um quarter específico do banco de dados.
     *
     * @param  \App\Models\Quarter  $quarter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Quarter $quarter): RedirectResponse
    {
        try {
            // Verificar se o quarter está sendo usado por MainObjectives ou Sprints antes de deletar,
            // dependendo da sua regra de negócio e das constraints da FK (ON DELETE SET NULL / RESTRICT).
            // Exemplo:
            if ($quarter->mainObjectives()->exists() || $quarter->sprints()->exists()) {
                 return redirect()->route('quarters.index')
                                ->with('error', 'Este trimestre/semestre não pode ser excluído pois está associado a objetivos ou sprints.');
            }

            $quarter->delete();
            return redirect()->route('quarters.index')
                             ->with('success', 'Trimestre/Semestre excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir Quarter ID ' . $quarter->id . ': ' . $e->getMessage());
            return redirect()->route('quarters.index')
                             ->with('error', 'Erro ao excluir o trimestre/semestre. Tente novamente.');
        }
    }
}
