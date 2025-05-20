<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\System; // Para carregar Sistemas nos formulários
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Para regras de validação avançadas (unique composto)

class ModuleController extends Controller
{
    /**
     * Construtor para aplicar middleware, se necessário.
     * Ex: apenas administradores podem gerenciar Módulos.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin'); // Exemplo de middleware de admin
    }

    /**
     * Exibe uma lista dos módulos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Module::with('system')->orderBy('name', 'asc');

        if ($request->has('system_id')) {
            $query->where('system_id', $request->input('system_id'));
        }

        $modules = $query->paginate(15);
        
        $system = null;
        if ($request->has('system_id')) {
            $system = System::find($request->input('system_id'));
        }

        return view('modules.index', compact('modules', 'system'));
        // Você precisará criar a view: resources/views/modules/index.blade.php
    }

    /**
     * Mostra o formulário para criar um novo módulo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        $systems = System::orderBy('name')->get();
        $selectedSystemId = $request->query('system_id'); // Para pré-selecionar

        return view('modules.create', compact('systems', 'selectedSystemId'));
        // Você precisará criar a view: resources/views/modules/create.blade.php
    }

    /**
     * Armazena um novo módulo no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request StoreModuleRequest
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('modules')->where(function ($query) use ($request) {
                    return $query->where('system_id', $request->input('system_id'));
                }),
            ],
            'system_id' => 'nullable|exists:systems,id',
        ]);

        try {
            Module::create($validatedData);
            $redirectParams = $validatedData['system_id'] ? ['system_id' => $validatedData['system_id']] : [];
            return redirect()->route('modules.index', $redirectParams)
                             ->with('success', 'Módulo criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Module: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao criar o Módulo. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Exibe os detalhes de um módulo específico.
     *
     * @param  \App\Models\Module  $module  // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(Module $module): View
    {
        $module->load(['system', 'tasks']); // Carrega o sistema pai e as tarefas associadas
        return view('modules.show', compact('module'));
        // Você precisará criar a view: resources/views/modules/show.blade.php
    }

    /**
     * Mostra o formulário para editar um módulo existente.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\View\View
     */
    public function edit(Module $module): View
    {
        $systems = System::orderBy('name')->get();
        return view('modules.edit', compact('module', 'systems'));
        // Você precisará criar a view: resources/views/modules/edit.blade.php
    }

    /**
     * Atualiza um módulo específico no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Module $module): RedirectResponse
    {
        // Para validações mais complexas, use Form Requests: php artisan make:request UpdateModuleRequest
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('modules')->where(function ($query) use ($request) {
                    return $query->where('system_id', $request->input('system_id'));
                })->ignore($module->id),
            ],
            'system_id' => 'nullable|exists:systems,id',
        ]);

        try {
            $module->update($validatedData);
            $redirectParams = $module->system_id ? ['system_id' => $module->system_id] : [];
            return redirect()->route('modules.index', $redirectParams)
                             ->with('success', 'Módulo atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar Module ID ' . $module->id . ': ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar o Módulo. Tente novamente.')
                             ->withInput();
        }
    }

    /**
     * Remove um módulo específico do banco de dados.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Module $module): RedirectResponse
    {
        try {
            $systemId = $module->system_id; // Guardar o ID do sistema para redirecionamento
            // De acordo com as migrations, as FKs em 'tasks' para 'modules'
            // foram definidas com ON DELETE SET NULL.
            // Tarefas associadas serão desvinculadas, mas não excluídas.
            $taskCount = $module->tasks()->count();
            $module->delete();

            $message = 'Módulo excluído com sucesso!';
            if ($taskCount > 0) {
                $message .= " As tarefas anteriormente associadas a este módulo não foram excluídas, mas foram desvinculadas.";
            }
            
            $redirectParams = $systemId ? ['system_id' => $systemId] : [];
            return redirect()->route('modules.index', $redirectParams)
                             ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir Module ID ' . $module->id . ': ' . $e->getMessage());
            return redirect()->route('modules.index')
                             ->with('error', 'Erro ao excluir o Módulo. Tente novamente.');
        }
    }
}