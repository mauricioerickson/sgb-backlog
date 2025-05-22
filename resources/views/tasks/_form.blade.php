@csrf {{-- CSRF Token --}}

<fieldset class="mb-6 border border-gray-300 dark:border-gray-600 p-4 rounded-md">
    <legend class="text-lg font-medium text-gray-700 dark:text-gray-300 px-2">{{ __('sgb.main_details') }}</legend> {{-- Chave nova: sgb.main_details --}}
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.task_title_label') }}</label>
        <input type="text" id="title" name="title" value="{{ old('title', $task->title ?? '') }}" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
        @error('title')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.description_label') }}</label>
        <textarea id="description" name="description" rows="5"
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</fieldset>

<fieldset class="mb-6 border border-gray-300 dark:border-gray-600 p-4 rounded-md">
    <legend class="text-lg font-medium text-gray-700 dark:text-gray-300 px-2">{{ __('sgb.associations_and_context') }}</legend> {{-- Chave nova: sgb.associations_and_context --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label for="feature_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.feature_associated_label') }}</label>
            <select id="feature_id" name="feature_id"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">{{ __('sgb.none_female') }}</option> {{-- Chave nova: sgb.none_female --}}
                @foreach ($features as $feature)
                    <option value="{{ $feature->id }}"
                        {{ old('feature_id', isset($task) ? $task->feature_id : ($selectedFeatureId ?? '')) == $feature->id ? 'selected' : '' }}>
                        {{ Str::limit($feature->title, 40) }} {{ $feature->mainObjective ? '(Obj: ' . Str::limit($feature->mainObjective->title, 20) . ')' : '' }}
                    </option>
                @endforeach
            </select>
            @error('feature_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="system_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.system_label_optional') }}</label>
            <select id="system_id" name="system_id"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">{{ __('sgb.none_male') }}</option> {{-- Chave nova: sgb.none_male --}}
                @foreach ($systems as $system)
                    <option value="{{ $system->id }}" {{ old('system_id', $task->system_id ?? '') == $system->id ? 'selected' : '' }}>
                        {{ $system->name }}
                    </option>
                @endforeach
            </select>
            @error('system_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="mb-4"> {{-- Module select fora do grid para ocupar largura total se necessário --}}
        <label for="module_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.module_label_optional') }}</label>
        <select id="module_id" name="module_id"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option value="">{{ __('sgb.none_male') }}</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}"
                    {{ old('module_id', isset($task) ? $task->module_id : ($selectedModuleId ?? '')) == $module->id ? 'selected' : '' }}
                    data-system-id="{{ $module->system_id }}">
                    {{ $module->name }} {{ $module->system ? '(' . $module->system->name . ')' : '' }}
                </option>
            @endforeach
        </select>
        @error('module_id')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</fieldset>

<fieldset class="mb-6 border border-gray-300 dark:border-gray-600 p-4 rounded-md">
    <legend class="text-lg font-medium text-gray-700 dark:text-gray-300 px-2">{{ __('sgb.classification_and_effort') }}</legend> {{-- Chave nova: sgb.classification_and_effort --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="mb-4">
            <label for="task_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.task_type_label') }}</label>
            <select id="task_type" name="task_type" required
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                @foreach ($taskTypes as $type)
                    <option value="{{ $type }}" {{ old('task_type', $task->task_type ?? '') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            @error('task_type')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.priority_label') }}</label>
            <select id="priority" name="priority" required
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                @foreach ($priorities as $priority)
                    <option value="{{ $priority }}" {{ old('priority', $task->priority ?? '') == $priority ? 'selected' : '' }}>
                        {{ $priority }}
                    </option>
                @endforeach
            </select>
            @error('priority')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="estimated_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.estimated_hours_label') }}</label>
            <input type="number" id="estimated_hours" name="estimated_hours" value="{{ old('estimated_hours', $task->estimated_hours ?? '') }}" step="0.1" min="0"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
            @error('estimated_hours')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
</fieldset>

<fieldset class="mb-6 border border-gray-300 dark:border-gray-600 p-4 rounded-md">
    <legend class="text-lg font-medium text-gray-700 dark:text-gray-300 px-2">{{ __('sgb.deadlines_and_sprints') }}</legend> {{-- Chave nova: sgb.deadlines_and_sprints --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.due_date_label_optional') }}</label>
            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date ?? '') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
            @error('due_date')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="start_sprint_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.start_sprint_label_optional') }}</label>
            <select id="start_sprint_id" name="start_sprint_id"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">{{ __('sgb.none_female') }}</option>
                @foreach ($sprints as $sprint)
                    <option value="{{ $sprint->id }}"
                        {{ old('start_sprint_id', isset($task) ? $task->start_sprint_id : ($selectedStartSprintId ?? '')) == $sprint->id ? 'selected' : '' }}>
                        {{ $sprint->name }}
                    </option>
                @endforeach
            </select>
            @error('start_sprint_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="delivery_sprint_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.delivery_sprint_label_optional') }}</label>
            <select id="delivery_sprint_id" name="delivery_sprint_id"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">{{ __('sgb.none_female') }}</option>
                @foreach ($sprints as $sprint)
                    <option value="{{ $sprint->id }}" {{ old('delivery_sprint_id', $task->delivery_sprint_id ?? '') == $sprint->id ? 'selected' : '' }}>
                        {{ $sprint->name }}
                    </option>
                @endforeach
            </select>
            @error('delivery_sprint_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
</fieldset>

<fieldset class="mb-6 border border-gray-300 dark:border-gray-600 p-4 rounded-md">
    <legend class="text-lg font-medium text-gray-700 dark:text-gray-300 px-2">{{ __('sgb.people_and_status') }}</legend> {{-- Chave nova: sgb.people_and_status --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="mb-4">
            <label for="requester_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.requester_label_optional') }}</label>
            <select id="requester_user_id" name="requester_user_id"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">{{ __('sgb.none_male') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('requester_user_id', $task->requester_user_id ?? (auth()->check() ? auth()->id() : '')) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('requester_user_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="assignee_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.assignee_label_optional') }}</label>
            <select id="assignee_user_id" name="assignee_user_id"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">{{ __('Ninguém') }}</option> {{-- Chave nova: sgb.nobody --}}
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('assignee_user_id', $task->assignee_user_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('assignee_user_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.status_label') }}</label>
            <select id="status" name="status" required
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ old('status', $task->status ?? 'Não Iniciado') == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
</fieldset>

<fieldset class="mb-6 border border-gray-300 dark:border-gray-600 p-4 rounded-md">
    <legend class="text-lg font-medium text-gray-700 dark:text-gray-300 px-2">{{ __('sgb.additional_information') }}</legend> {{-- Chave nova: sgb.additional_information --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label for="helpdesk_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.helpdesk_link_label_optional') }}</label>
            <input type="url" id="helpdesk_link" name="helpdesk_link" value="{{ old('helpdesk_link', $task->helpdesk_link ?? '') }}" placeholder="https://..."
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
            @error('helpdesk_link')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="mb-4">
        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('sgb.internal_notes_label_optional') }}</label>
        <textarea id="notes" name="notes" rows="3"
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">{{ old('notes', $task->notes ?? '') }}</textarea>
        @error('notes')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</fieldset>

<div class="flex items-center justify-end space-x-4 mt-6">
    <a href="{{ isset($task) ? route('tasks.show', $task) : route('tasks.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        {{ __('sgb.cancel') }}
    </a>
    <button type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
        {{ isset($task) ? __('sgb.update') . ' ' . __('sgb.task') : __('sgb.save') . ' ' . __('sgb.task') }}
    </button>
</div>

{{-- Script simples para filtrar módulos por sistema (exemplo básico) --}}
{{-- Para uma solução robusta, considere Vue/React/Alpine.js ou AJAX para buscar módulos --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const systemSelect = document.getElementById('system_id');
        const moduleSelect = document.getElementById('module_id');
        // Guardar todas as opções originais do select de módulos
        const originalModuleOptions = Array.from(moduleSelect.options).map(option => ({
            value: option.value,
            text: option.text,
            systemId: option.dataset.systemId
        }));

        if (systemSelect) {
            systemSelect.addEventListener('change', function () {
                const selectedSystemId = this.value;
                const currentModuleValue = moduleSelect.value; // Guardar o valor atual do módulo, se houver

                // Limpar opções atuais, exceto a primeira ("Nenhum")
                while (moduleSelect.options.length > 1) {
                    moduleSelect.remove(1);
                }
                 // Garantir que a opção "Nenhum" esteja selecionada se nenhum sistema estiver
                if (!selectedSystemId) {
                     moduleSelect.value = "";
                }


                originalModuleOptions.forEach(function(optionData) {
                    if (optionData.value === "") return; // Não readicionar a opção "Nenhum" aqui se ela já existe
                    if (!selectedSystemId || optionData.systemId === selectedSystemId) {
                        const option = document.createElement('option');
                        option.value = optionData.value;
                        option.text = optionData.text;
                        option.dataset.systemId = optionData.systemId;
                        moduleSelect.add(option);
                    }
                });

                // Tentar restaurar o valor do módulo se ainda for válido para o novo sistema
                if (selectedSystemId) {
                    if (Array.from(moduleSelect.options).some(opt => opt.value === currentModuleValue && opt.dataset.systemId === selectedSystemId)) {
                        moduleSelect.value = currentModuleValue;
                    } else {
                         // Se o valor antigo não for válido, e não for "Nenhum", definir para "Nenhum"
                         if (moduleSelect.value !== "") {
                            moduleSelect.value = "";
                         }
                    }
                }
            });

            // Disparar o evento change na carga da página para filtrar inicialmente
            if (systemSelect.value) {
                systemSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>