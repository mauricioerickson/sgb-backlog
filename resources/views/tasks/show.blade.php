@extends('layouts.app')

@section('title', 'Detalhes da Tarefa - SGB')

@section('content')
    <h2>Detalhes da Tarefa: {{ $task->title }}</h2>

    <div class="grid-container"> {{-- Usando grid para melhor layout dos detalhes --}}
        <div class="card">
            <div class="card-header">Informações Principais</div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $task->id }}</p>
                <p><strong>Título:</strong> {{ $task->title }}</p>
                <p><strong>Descrição:</strong> {!! nl2br(e($task->description)) ?: 'N/A' !!}</p>
                <p><strong>Tipo:</strong> {{ $task->task_type }}</p>
                <p><strong>Prioridade:</strong> <span style="font-weight:bold; color: @switch($task->priority) @case('Crítica') red @break @case('Alta') orange @break @case('Média') #6c757d @break @default black @endswitch">{{ $task->priority }}</span></p>
                <p><strong>Status:</strong> <span style="font-weight:bold; color: @switch($task->status) @case('Concluído') green @break @case('Em Andamento') blue @break @case('Bloqueada') red @break @case('Cancelada') grey @break @default black @endswitch">{{ $task->status }}</span></p>
                <p><strong>Horas Estimadas:</strong> {{ $task->estimated_hours ?: 'N/A' }}</p>
                <p><strong>Data de Vencimento:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'N/A' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Associações</div>
            <div class="card-body">
                <p><strong>Funcionalidade:</strong>
                    @if($task->feature)
                        <a href="{{ route('features.show', $task->feature->id) }}">{{ $task->feature->title }}</a>
                        @if($task->feature->mainObjective)
                            <br><small><em>(Objetivo: <a href="{{ route('main-objectives.show', $task->feature->mainObjective->id) }}">{{ $task->feature->mainObjective->title }}</a>)</em></small>
                        @endif
                    @else
                        N/A
                    @endif
                </p>
                <p><strong>Sistema:</strong> {{ $task->system->name ?? 'N/A' }}</p>
                <p><strong>Módulo:</strong> {{ $task->module->name ?? 'N/A' }}
                    @if($task->module && $task->module->system)
                        <small><em>({{ $task->module->system->name }})</em></small>
                    @endif
                </p>
                <p><strong>Sprint de Início:</strong> {{ $task->startSprint->name ?? 'N/A' }}</p>
                <p><strong>Sprint de Entrega:</strong> {{ $task->deliverySprint->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Pessoas e Informações Adicionais</div>
            <div class="card-body">
                <p><strong>Solicitante:</strong> {{ $task->requester->name ?? 'N/A' }}</p>
                <p><strong>Responsável:</strong> {{ $task->assignee->name ?? 'N/A' }}</p>
                <p><strong>Link Helpdesk:</strong> {!! $task->helpdesk_link ? '<a href="'.$task->helpdesk_link.'" target="_blank">'.$task->helpdesk_link.'</a>' : 'N/A' !!}</p>
                <p><strong>Notas Internas:</strong> {!! nl2br(e($task->notes)) ?: 'N/A' !!}</p>
                <p><strong>Criada em:</strong> {{ $task->created_at ? $task->created_at->format('d/m/Y H:i:s') : '-' }}</p>
                <p><strong>Atualizada em:</strong> {{ $task->updated_at ? $task->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
            </div>
        </div>
    </div>


    <hr style="margin: 30px 0;">
    <h3>Comentários ({{ $task->comments->count() }})</h3>
    <div class="comments-section" style="margin-bottom: 20px;">
        @forelse($task->comments->sortByDesc('created_at') as $comment)
            <div class="card" style="margin-bottom: 10px;">
                <div class="card-body">
                    <p><strong>{{ $comment->author->name ?? 'Usuário Anônimo' }}</strong>
                        <small style="color: #777; font-size: 0.85em;">em {{ $comment->created_at->format('d/m/Y H:i') }}</small>
                    </p>
                    <p>{!! nl2br(e($comment->comment)) !!}</p>
                    {{-- Adicionar link/botão para excluir comentário se o usuário logado for o autor ou admin --}}
                </div>
            </div>
        @empty
            <p>Nenhum comentário ainda.</p>
        @endforelse
    </div>

    {{-- Formulário para Novo Comentário --}}
    <div class="card">
        <div class="card-header">Adicionar Novo Comentário</div>
        <div class="card-body">
            <form action="{{ route('tasks.comments.store', $task) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment_text">Seu Comentário:</label>
                    <textarea id="comment_text" name="comment" rows="3" required class="@error('comment', 'commentForm') is-invalid @enderror"></textarea>
                    @error('comment', 'commentForm') {{-- Usar um error bag diferente se necessário --}}
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Assumindo que o autor do comentário é o usuário logado. O TaskCommentController deve lidar com isso. --}}
                <button type="submit" class="btn btn-primary">Enviar Comentário</button>
            </form>
        </div>
    </div>


    <div style="margin-top: 30px;">
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Editar Tarefa</a>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Voltar para a Lista de Tarefas</a>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline; margin-left: 5px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta tarefa? Todos os comentários associados também serão excluídos.')">Excluir Tarefa</button>
        </form>
    </div>

@endsection