<?php

namespace App\Http\Controllers;

use App\Models\Task; // Para type-hinting da tarefa à qual o comentário pertence
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // Para obter o usuário autenticado
use Illuminate\Support\Facades\Log;

class TaskCommentController extends Controller
{
    /**
     * Construtor para aplicar middleware.
     * Apenas usuários autenticados podem criar comentários.
     */
    public function __construct()
    {
        // $this->middleware('auth'); // Garante que apenas usuários logados possam acessar os métodos deste controller
    }

    /**
     * Armazena um novo comentário para uma tarefa específica.
     * A rota para este método é: POST /tasks/{task}/comments
     * Nome da rota: tasks.comments.store
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task   // Route Model Binding para a tarefa pai
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Task $task): RedirectResponse
    {
        // 1. Validar os dados do request
        // Para validações mais complexas, poderia ser usado um Form Request:
        // php artisan make:request StoreTaskCommentRequest
        $validatedData = $request->validateWithBag('commentForm', [ // Usando um error bag específico
            'comment' => 'required|string|min:3|max:5000', // Comentário é obrigatório
        ]);
        // O nome 'commentForm' no validateWithBag é opcional, mas útil se você tiver múltiplos formulários na mesma página
        // e quiser separar as mensagens de erro. Na view tasks.show, o @error('comment', 'commentForm') já está configurado.

        try {
            // 2. Criar e salvar o novo comentário
            $comment = new TaskComment();
            $comment->comment = $validatedData['comment'];
            $comment->task_id = $task->id; // Associa o comentário à tarefa
            $comment->author_user_id = Auth::id(); // Associa o comentário ao usuário autenticado
            // Alternativamente: $comment->author_user_id = $request->user()->id;

            $comment->save();

            // 3. Redirecionar de volta para a página da tarefa com uma mensagem de sucesso
            return redirect()->route('tasks.show', $task)
                             ->with('success', 'Comentário adicionado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao salvar comentário para Tarefa ID ' . $task->id . ': ' . $e->getMessage());
            return redirect()->route('tasks.show', $task)
                             ->with('error', 'Erro ao adicionar o comentário. Tente novamente.')
                             ->withInput(); // Retorna com os inputs para o formulário
        }
    }

    /**
     * Remove um comentário específico.
     * (Método de exemplo se você quiser adicionar a funcionalidade de exclusão)
     * Rota: DELETE /comments/{comment} (ou /tasks/{task}/comments/{comment})
     *
     * @param  \App\Models\TaskComment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TaskComment $comment): RedirectResponse
    {
        // 1. Autorização: Verificar se o usuário logado pode excluir este comentário
        // Ex: Se o usuário é o autor do comentário ou um administrador
        if (Auth::id() !== $comment->author_user_id /* && !Auth::user()->isAdmin() */) {
            // Se você tiver um sistema de roles/permissions, use Gates ou Policies
            // Gate::authorize('delete', $comment);
            return redirect()->route('tasks.show', $comment->task_id)
                             ->with('error', 'Você não tem permissão para excluir este comentário.');
        }

        try {
            $taskId = $comment->task_id; // Guardar o ID da tarefa para redirecionamento
            $comment->delete();

            return redirect()->route('tasks.show', $taskId)
                             ->with('success', 'Comentário excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir Comentário ID ' . $comment->id . ': ' . $e->getMessage());
            return redirect()->route('tasks.show', $comment->task_id) // Tentar redirecionar para a tarefa
                             ->with('error', 'Erro ao excluir o comentário. Tente novamente.');
        }
    }

    // Você pode adicionar métodos edit() e update() aqui se precisar da funcionalidade de edição de comentários.
    // Lembre-se de definir as rotas correspondentes em routes/web.php.
}