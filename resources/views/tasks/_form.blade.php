{{-- Este arquivo será incluído nas views create.blade.php e edit.blade.php --}}

@csrf {{-- CSRF Token --}}

<fieldset>
    <legend>Detalhes Principais</legend>
    <div class="form-group">
        <label for="title">Título da Tarefa:</label>
        <input type="text" id="title" name="title" value="{{ old('title', $task->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Descrição:</label>
        <textarea id="description" name="description" rows="5">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Associações e Contexto</legend>
    <div class="form-group">
        <label for="feature_id">Funcionalidade Associada (Opcional):</label>
        <select id="feature_id" name="feature_id">
            <option value="">Nenhuma</option>
            @foreach ($features as $feature)
                <option value="{{ $feature->id }}"
                    {{ old('feature_id', isset($task) ? $task->feature_id : ($selectedFeatureId ?? '')) == $feature->id ? 'selected' : '' }}>
                    {{ $feature->title }} (Obj: {{ $feature->mainObjective->title ?? 'N/A' }})
                </option>
            @endforeach
        </select>
        @error('feature_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="system_id">Sistema (Opcional):</label>
        <select id="system_id" name="system_id">
            <option value="">Nenhum</option>
            @foreach ($systems as $system)
                <option value="{{ $system->id }}" {{ old('system_id', $task->system_id ?? '') == $system->id ? 'selected' : '' }}>
                    {{ $system->name }}
                </option>
            @endforeach
        </select>
        @error('system_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="module_id">Módulo (Opcional):</label>
        {{-- Idealmente, este select seria populado/filtrado por JS com base no Sistema selecionado --}}
        <select id="module_id" name="module_id">
            <option value="">Nenhum</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}"
                    {{ old('module_id', isset($task) ? $task->module_id : ($selectedModuleId ?? '')) == $module->id ? 'selected' : '' }}
                    data-system-id="{{ $module->system_id }}">
                    {{ $module->name }} {{ $module->system ? '(' . $module->system->name . ')' : '' }}
                </option>
            @endforeach
        </select>
        @error('module_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Classificação e Esforço</legend>
    <div class="form-group">
        <label for="task_type">Tipo de Tarefa:</label>
        <select id="task_type" name="task_type" required>
            @foreach ($taskTypes as $type)
                <option value="{{ $type }}" {{ old('task_type', $task->task_type ?? '') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
        @error('task_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="priority">Prioridade:</label>
        <select id="priority" name="priority" required>
            @foreach ($priorities as $priority)
                <option value="{{ $priority }}" {{ old('priority', $task->priority ?? '') == $priority ? 'selected' : '' }}>
                    {{ $priority }}
                </option>
            @endforeach
        </select>
        @error('priority')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="estimated_hours">Horas Estimadas (Opcional):</label>
        <input type="number" id="estimated_hours" name="estimated_hours" value="{{ old('estimated_hours', $task->estimated_hours ?? '') }}" step="0.1" min="0">
        @error('estimated_hours')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Prazos e Sprints</legend>
    <div class="form-group">
        <label for="due_date">Data de Vencimento (Opcional):</label>
        <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date ?? '') }}">
        @error('due_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="start_sprint_id">Sprint de Início (Opcional):</label>
        <select id="start_sprint_id" name="start_sprint_id">
            <option value="">Nenhuma</option>
            @foreach ($sprints as $sprint)
                <option value="{{ $sprint->id }}"
                    {{ old('start_sprint_id', isset($task) ? $task->start_sprint_id : ($selectedStartSprintId ?? '')) == $sprint->id ? 'selected' : '' }}>
                    {{ $sprint->name }}
                </option>
            @endforeach
        </select>
        @error('start_sprint_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="delivery_sprint_id">Sprint de Entrega (Opcional):</label>
        <select id="delivery_sprint_id" name="delivery_sprint_id">
            <option value="">Nenhuma</option>
            @foreach ($sprints as $sprint)
                <option value="{{ $sprint->id }}" {{ old('delivery_sprint_id', $task->delivery_sprint_id ?? '') == $sprint->id ? 'selected' : '' }}>
                    {{ $sprint->name }}
                </option>
            @endforeach
        </select>
        @error('delivery_sprint_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Pessoas e Status</legend>
    <div class="form-group">
        <label for="requester_user_id">Solicitante (Opcional):</label>
        <select id="requester_user_id" name="requester_user_id">
            <option value="">Nenhum</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('requester_user_id', $task->requester_user_id ?? (auth()->check() ? auth()->id() : '')) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('requester_user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="assignee_user_id">Responsável (Atribuído Para - Opcional):</label>
        <select id="assignee_user_id" name="assignee_user_id">
            <option value="">Ninguém</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('assignee_user_id', $task->assignee_user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('assignee_user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ old('status', $task->status ?? 'Não Iniciado') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Informações Adicionais</legend>
    <div class="form-group">
        <label for="helpdesk_link">Link do Helpdesk (Opcional):</label>
        <input type="url" id="helpdesk_link" name="helpdesk_link" value="{{ old('helpdesk_link', $task->helpdesk_link ?? '') }}" placeholder="https://...">
        @error('helpdesk_link')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="notes">Notas Internas (Opcional):</label>
        <textarea id="notes" name="notes" rows="3">{{ old('notes', $task->notes ?? '') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<button type="submit" class="btn btn-primary">{{ isset($task) ? 'Atualizar Tarefa' : 'Salvar Tarefa' }}</button>
<a href="{{ isset($task) ? route('tasks.show', $task) : route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>

{{-- Script simples para filtrar módulos por sistema (exemplo básico) --}}
{{-- Para uma solução robusta, considere Vue/React/Alpine.js ou AJAX para buscar módulos --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const systemSelect = document.getElementById('system_id');
        const moduleSelect = document.getElementById('module_id');
        const originalModuleOptions = Array.from(moduleSelect.options);

        if (systemSelect) {
            systemSelect.addEventListener('change', function () {
                const selectedSystemId = this.value;
                moduleSelect.innerHTML = ''; // Limpa opções atuais

                originalModuleOptions.forEach(function(option) {
                    if (!selectedSystemId || option.value === "" || option.dataset.systemId === selectedSystemId) {
                        moduleSelect.add(option.cloneNode(true));
                    }
                });
                 // Resetar para a opção "Nenhum" se o sistema for desselecionado ou se não houver módulos para o sistema
                if (!selectedSystemId) {
                    moduleSelect.value = "";
                } else {
                    // Se o valor antigo do módulo ainda for válido para o novo sistema, tente restaurá-lo
                    let oldModuleValue = "{{ old('module_id', $task->module_id ?? '') }}";
                    if (Array.from(moduleSelect.options).some(opt => opt.value === oldModuleValue && (opt.dataset.systemId === selectedSystemId || opt.value === ""))) {
                        moduleSelect.value = oldModuleValue;
                    } else {
                        moduleSelect.value = ""; // Ou o primeiro módulo válido, se preferir
                    }
                }
            });

            // Disparar o evento change na carga da página para filtrar inicialmente se um sistema já estiver selecionado (ex: no edit ou com old value)
            if (systemSelect.value) {
                systemSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>