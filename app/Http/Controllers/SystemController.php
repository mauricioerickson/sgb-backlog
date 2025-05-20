<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    /**
     * Construtor para aplicar middleware, se necessário.
     * Ex: apenas administradores podem gerenciar Sistemas.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin'); // Exemplo de middleware de admin
    }

    /**
     * Exibe uma lista dos sistemas.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $systems = System::orderBy('name', 'asc')->paginate(15);
        return view('systems.index', compact('systems'));
        // Você precisará criar a view: resources/views/systems/index.blade.php
    }

    /**
     * Mostra o formulário para criar um novo sistema.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('systems.create');
        // Você precisará criar a view: resources/views/systems/create.blade.php
    }

    /**
     * Armazena um novo sistema no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request StoreSystemRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:systems,name',
        ]);

        try {
            System::create($validatedData);
            return redirect()->route('systems.index')
                             ->with('success', 'Sistema criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar System: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao criar o Sistema. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Exibe os detalhes de um sistema específico.
     *
     * @param  \App\Models\System  $system  // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(System $system): View
    {
        // Carregar relacionamentos se for exibi-los na view show
        // Ex: $system->load(['modules', 'tasks']);
        // No entanto, para um sistema simples, talvez não haja muito o que mostrar além do nome.
        // Poderia listar os módulos e tarefas associados.
        $system->load(['modules', 'tasks']);
        return view('systems.show', compact('system'));
        // Você precisará criar a view: resources/views/systems/show.blade.php
    }

    /**
     * Mostra o formulário para editar um sistema existente.
     *
     * @param  \App\Models\System  $system
     * @return \Illuminate\View\View
     */
    public function edit(System $system): View
    {
        return view('systems.edit', compact('system'));
        // Você precisará criar a view: resources/views/systems/edit.blade.php
    }

    /**
     * Atualiza um sistema específico no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\System  $system
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, System $system): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request UpdateSystemRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:systems,name,' . $system->id,
        ]);

        try {
            $system->update($validatedData);
            return redirect()->route('systems.index')
                             ->with('success', 'Sistema atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar System ID ' . $system->id . ': ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar o Sistema. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Remove um sistema específico do banco de dados.
     *
     * @param  \App\Models\System  $system
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(System $system): RedirectResponse
    {
        try {
            // De acordo com as migrations, as FKs em 'modules' e 'tasks' para 'systems'
            // foram definidas com ON DELETE SET NULL.
            // Isso significa que, ao deletar um sistema, os 'system_id' nos módulos e tarefas
            // associados se tornarão NULL, mas os módulos e tarefas em si não serão excluídos.
            // Pode ser útil avisar o usuário sobre isso ou contar quantos itens serão desassociados.

            $moduleCount = $system->modules()->count();
            $taskCount = $system->tasks()->count();

            $system->delete();

            $message = 'Sistema excluído com sucesso!';
            if ($moduleCount > 0 || $taskCount > 0) {
                $message .= " Os módulos e tarefas anteriormente associados a este sistema não foram excluídos, mas foram desvinculados.";
            }

            return redirect()->route('systems.index')
                             ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir System ID ' . $system->id . ': ' . $e->getMessage());
            return redirect()->route('systems.index')
                             ->with('error', 'Erro ao excluir o Sistema. Tente novamente.');
        }
    }
}