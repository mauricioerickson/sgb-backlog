@extends('layouts.app')

@section('title', __('sgb.view_task') . ': ' . $task->title . ' - ' . __('sgb.sgb'))

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('sgb.view_task') }}: <span class="text-blue-600 dark:text-blue-400">{{ $task->title }}</span>
        </h2>
    </div>

    {{-- Detalhes da Tarefa em Grid de Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        {{-- Card: Informações Principais --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.main_details') }}</h3>
            <div class="space-y-3 text-sm">
                <p><strong>{{ __('sgb.id') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->id }}</span></p>
                <p><strong>{{ __('sgb.task_title_label') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->title }}</span></p>
                <div>
                    <strong>{{ __('sgb.description_label') }}</strong>
                    <div class="mt-1 text-gray-600 dark:text-gray-400 prose prose-sm dark:prose-invert max-w-none">{!! nl2br(e($task->description)) ?: __('sgb.not_available_short') !!}</div>
                </div>
                <p><strong>{{ __('sgb.task_type_label') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->task_type }}</span></p>
                <p><strong>{{ __('sgb.priority_label') }}</strong>
                    <span class="font-semibold px-2 py-0.5 rounded-full text-xs
                        @switch($task->priority)
                            @case('Crítica') bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100 @break
                            @case('Alta') bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100 @break
                            @case('Média') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @break
                            @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                        @endswitch">
                        {{ $task->priority }}
                    </span>
                </p>
                <p><strong>{{ __('sgb.status_label') }}</strong>
                    <span class="font-semibold px-2 py-0.5 rounded-full text-xs
                        @switch($task->status)
                            @case('Concluído') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @break
                            @case('Em Andamento') bg-sky-100 text-sky-800 dark:bg-sky-700 dark:text-sky-100 @break
                            @case('Bloqueada')
                            @case('Cancelada') bg-pink-100 text-pink-800 dark:bg-pink-700 dark:text-pink-100 @break
                            @case('Pausado') bg-orange-100 text-orange-800 dark:bg-orange-600 dark:text-orange-100 @break
                            @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                        @endswitch">
                        {{ $task->status }}
                    </span>
                </p>
                <p><strong>{{ __('sgb.estimated_hours_label') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->estimated_hours ?: __('sgb.not_available_short') }}</span></p>
                <p><strong>{{ __('sgb.due_date_label_optional') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : __('sgb.not_available_short') }}</span></p>
            </div>
        </div>

        {{-- Card: Associações --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.associations_and_context') }}</h3>
            <div class="space-y-3 text-sm">
                <p><strong>{{ __('sgb.feature') }}:</strong>
                    @if($task->feature)
                        <a href="{{ route('features.show', $task->feature->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $task->feature->title }}</a>
                        @if($task->feature->mainObjective)
                            <br><small class="text-gray-500 dark:text-gray-400"><em>({{ __('sgb.main_objective') }}: <a href="{{ route('main-objectives.show', $task->feature->mainObjective->id) }}" class="text-gray-500 hover:underline dark:text-gray-400">{{ $task->feature->mainObjective->title }}</a>)</em></small>
                        @endif
                    @else
                        <span class="text-gray-600 dark:text-gray-400">{{ __('sgb.not_available_short') }}</span>
                    @endif
                </p>
                <p><strong>{{ __('sgb.system') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->system->name ?? __('sgb.not_available_short') }}</span></p>
                <p><strong>{{ __('sgb.module') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->module->name ?? __('sgb.not_available_short') }}</span>
                    @if($task->module && $task->module->system)
                        <small class="text-gray-500 dark:text-gray-400"><em>({{ $task->module->system->name }})</em></small>
                    @endif
                </p>
                <p><strong>{{ __('sgb.start_sprint_label_optional') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->startSprint->name ?? __('sgb.not_available_short') }}</span></p>
                <p><strong>{{ __('sgb.delivery_sprint_label_optional') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->deliverySprint->name ?? __('sgb.not_available_short') }}</span></p>
            </div>
        </div>

        {{-- Card: Pessoas e Informações Adicionais --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">{{ __('sgb.people_and_status') }}</h3> {{-- Reutilizei people_and_status para este card, pode criar uma chave nova se preferir --}}
            <div class="space-y-3 text-sm">
                <p><strong>{{ __('sgb.requester_label_optional') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->requester->name ?? __('sgb.not_available_short') }}</span></p>
                <p><strong>{{ __('sgb.assignee_label_optional') }}</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->assignee->name ?? __('sgb.not_available_short') }}</span></p>
                <p><strong>{{ __('sgb.helpdesk_link_label_optional') }}</strong>
                    @if($task->helpdesk_link)
                        <a href="{{ $task->helpdesk_link }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">{{ $task->helpdesk_link }}</a>
                    @else
                        <span class="text-gray-600 dark:text-gray-400">{{ __('sgb.not_available_short') }}</span>
                    @endif
                </p>
                <div>
                    <strong>{{ __('sgb.internal_notes_label_optional') }}</strong>
                    <div class="mt-1 text-gray-600 dark:text-gray-400 prose prose-sm dark:prose-invert max-w-none">{!! nl2br(e($task->notes)) ?: __('sgb.not_available_short') !!}</div>
                </div>
                <p><strong>{{ __('sgb.created_at') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->created_at ? $task->created_at->format('d/m/Y H:i:s') : '-' }}</span></p>
                <p><strong>{{ __('sgb.updated_at') }}:</strong> <span class="text-gray-600 dark:text-gray-400">{{ $task->updated_at ? $task->updated_at->format('d/m/Y H:i:s') : '-' }}</span></p>
            </div>
        </div>
    </div>

    <hr class="my-8 border-gray-300 dark:border-gray-600">

    {{-- Seção de Comentários --}}
    <div class="mt-6">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">{{ __('sgb.comments') }} ({{ $task->comments->count() }})</h3>
        <div class="space-y-4 mb-6">
            @forelse($task->comments->sortByDesc('created_at') as $comment)
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $comment->author->name ?? __('Usuário Anônimo') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }} ({{ $comment->created_at->format('d/m/Y H:i') }})</p>
                    </div>
                    <div class="text-sm text-gray-700 dark:text-gray-300 prose prose-sm dark:prose-invert max-w-none">{!! nl2br(e($comment->comment)) !!}</div>
                    {{-- TODO: Adicionar botões de Editar/Excluir comentário com autorização --}}
                </div>
            @empty
                <div class="bg-yellow-50 dark:bg-gray-700 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 rounded-md">
                    <p class="text-yellow-700 dark:text-yellow-200">{{ __('sgb.no_comments_yet') }}</p>
                </div>
            @endforelse
        </div>

        {{-- Formulário para Novo Comentário --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3">{{ __('sgb.add_new_comment') }}</h4>
            <form action="{{ route('tasks.comments.store', $task) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="comment_text" class="sr-only">{{ __('sgb.your_comment_label') }}</label>
                    <textarea id="comment_text" name="comment" rows="4" required
                              class="mt-1 block w-full px-3 py-2 border {{ $errors->commentForm->has('comment') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }} rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200"
                              placeholder="{{ __('sgb.your_comment_label') }}">{{ old('comment') }}</textarea>
                    @error('comment', 'commentForm')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        {{ __('sgb.send_comment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Botões de Ação da Tarefa --}}
    <div class="mt-8 flex items-center justify-start space-x-3">
        <a href="{{ route('tasks.edit', $task) }}"
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
           {{ __('sgb.edit_task') }}
        </a>
        <a href="{{ route('tasks.index') }}"
           class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
           {{ __('sgb.back_to_list') }}
        </a>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('sgb.confirm_delete_message_cascade', ['related_items' => strtolower(__('sgb.comments'))]) }}');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                {{ __('sgb.delete_task') }} {{-- Chave nova: sgb.delete_task --}}
            </button>
        </form>
    </div>
@endsection