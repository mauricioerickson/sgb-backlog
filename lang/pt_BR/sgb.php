<?php

return [
    //--------------------------------------------------------------------------
    // Termos Gerais e Ações Comuns
    //--------------------------------------------------------------------------
    'sgb'                                   => 'SGB', // Nome curto ou sigla do projeto
    'app_name'                              => 'Sistema Gerenciador de Backlog',
    'dashboard'                             => 'Painel Principal',
    'actions'                               => 'Ações',
    'id'                                    => 'ID',
    'name'                                  => 'Nome',
    'title'                                 => 'Título',
    'description'                           => 'Descrição',
    'status'                                => 'Status',
    'priority'                              => 'Prioridade',
    'type'                                  => 'Tipo',
    'notes'                                 => 'Notas',
    'save'                                  => 'Salvar',
    'create'                                => 'Criar',
    'add_new'                               => 'Adicionar Novo(a)',
    'edit'                                  => 'Editar',
    'update'                                => 'Atualizar',
    'delete'                                => 'Excluir',
    'view'                                  => 'Ver',
    'cancel'                                => 'Cancelar',
    'search'                                => 'Buscar',
    'filter'                                => 'Filtrar',
    'clear_filters'                         => 'Limpar Filtros',
    'back_to_list'                          => 'Voltar para a Lista',
    'no_records_found'                      => 'Nenhum registro encontrado.',
    'confirm_delete_title'                  => 'Confirmar Exclusão',
    'confirm_delete_message'                => 'Tem certeza que deseja excluir este item?',
    'confirm_delete_message_cascade'        => 'Tem certeza que deseja excluir este item? Todos os dados associados (como :related_items) também serão excluídos.',
    'confirm_delete_message_dissociate'     => 'Tem certeza que deseja excluir este item? Os :related_items associados serão desvinculados, mas não excluídos.',
    'all_female'                            => 'Todas', // Para "Prioridade: Todas"
    'all_male'                              => 'Todos', // Para "Status: Todos"
    'not_available_short'                   => 'N/D', // Para "Não Disponível / Não Definido"
    'of'                                    => 'de', // Ex: "Módulos de Sistema X"
    'created_at'                            => 'Criado em',
    'updated_at'                            => 'Atualizado em',

    //--------------------------------------------------------------------------
    // Mensagens de Feedback (Flash Messages)
    //--------------------------------------------------------------------------
    'success_created'                       => ':Item criado(a) com sucesso!',
    'success_updated'                       => ':Item atualizado(a) com sucesso!',
    'success_deleted'                       => ':Item excluído(a) com sucesso!',
    'success_comment_added'                 => 'Comentário adicionado com sucesso!',
    'error_generic'                         => 'Ocorreu um erro. Por favor, tente novamente.',
    'error_not_found'                       => ':Item não encontrado(a).',
    'error_delete_constraint'               => 'Este item não pode ser excluído pois está associado a :related_items.',

    //--------------------------------------------------------------------------
    // Dashboard
    //--------------------------------------------------------------------------
    'welcome_dashboard'                     => 'Bem-vindo(a) ao Sistema Gerenciador de Backlog!',
    'total_objectives'                      => 'Total de Objetivos',
    'objectives_in_progress'                => 'Objetivos em Andamento',
    'total_features'                        => 'Total de Funcionalidades',
    'pending_tasks'                         => 'Tarefas Pendentes/Em Andamento',
    'completed_tasks_today'                 => 'Tarefas Concluídas Hoje',
    'general_settings'                      => 'Configurações Gerais',
    'manage_base_data'                      => 'Gerencie os dados base do sistema.',

    //--------------------------------------------------------------------------
    // Quarters (Trimestres/Semestres)
    //--------------------------------------------------------------------------
    'quarters'                              => 'Trimestres/Semestres',
    'quarter'                               => 'Trimestre/Semestre', // Singular
    'quarter_name'                          => 'Nome do Período',
    'quarter_name_label'                    => 'Nome do Período:', // Para formulários
    'start_date'                            => 'Data de Início',
    'start_date_label'                      => 'Data de Início:',
    'end_date'                              => 'Data de Fim',
    'end_date_label'                        => 'Data de Fim:',
    'new_quarter'                           => 'Novo Período',
    'edit_quarter'                          => 'Editar Período',
    'view_quarter'                          => 'Detalhes do Período',
    'no_quarters_found'                     => 'Nenhum período cadastrado.',
    'sprints_in_this_quarter'               => 'Sprints neste Período',

    //--------------------------------------------------------------------------
    // Main Objectives (Objetivos Principais)
    //--------------------------------------------------------------------------
    'main_objectives'                       => 'Objetivos Principais',
    'main_objective'                        => 'Objetivo Principal', // Singular
    'objective_title_label'                 => 'Título do Objetivo:',
    'description_label'                     => 'Descrição:',
    'quarter_associated_label'              => 'Período Associado:',
    'responsible_label'                     => 'Responsável:',
    'status_label'                          => 'Status:',
    'notes_label'                           => 'Notas Adicionais:',
    'new_main_objective'                    => 'Novo Objetivo Principal',
    'edit_main_objective'                   => 'Editar Objetivo Principal',
    'view_main_objective'                   => 'Detalhes do Objetivo',
    'no_main_objectives_found'              => 'Nenhum objetivo principal cadastrado.',
    'features_associated_to_objective'      => 'Funcionalidades Associadas a este Objetivo',
    'no_features_for_objective'             => 'Nenhuma funcionalidade associada a este objetivo.',
    'new_feature_for_objective'             => 'Nova Funcionalidade para este Objetivo',
    'back_to_objective'                     => 'Voltar para o Objetivo',

    //--------------------------------------------------------------------------
    // Features (Funcionalidades)
    //--------------------------------------------------------------------------
    'features'                              => 'Funcionalidades',
    'feature'                               => 'Funcionalidade', // Singular
    'feature_title_label'                   => 'Título da Funcionalidade:',
    'main_objective_associated_label'       => 'Objetivo Principal Associado:',
    'new_feature'                           => 'Nova Funcionalidade',
    'edit_feature'                          => 'Editar Funcionalidade',
    'view_feature'                          => 'Detalhes da Funcionalidade',
    'no_features_found'                     => 'Nenhuma funcionalidade cadastrada.',
    'tasks_associated_to_feature'           => 'Tarefas Associadas a esta Funcionalidade',
    'no_tasks_for_feature'                  => 'Nenhuma tarefa associada a esta funcionalidade.',
    'new_task_for_feature'                  => 'Nova Tarefa para esta Funcionalidade',
    'for_this_objective'                    => 'para este objetivo', // para msg "nenhuma funcionalidade para este objetivo"

    //--------------------------------------------------------------------------
    // Tasks (Tarefas)
    //--------------------------------------------------------------------------
    'tasks'                                 => 'Tarefas',
    'task'                                  => 'Tarefa', // Singular
    'task_title_label'                      => 'Título da Tarefa:',
    'feature_associated_label'              => 'Funcionalidade Associada (Opcional):',
    'system_label_optional'                 => 'Sistema (Opcional):',
    'module_label_optional'                 => 'Módulo (Opcional):',
    'task_type_label'                       => 'Tipo de Tarefa:',
    'priority_label'                        => 'Prioridade:',
    'estimated_hours_label'                 => 'Horas Estimadas (Opcional):',
    'due_date_label_optional'               => 'Data de Vencimento (Opcional):',
    'start_sprint_label_optional'           => 'Sprint de Início (Opcional):',
    'delivery_sprint_label_optional'        => 'Sprint de Entrega (Opcional):',
    'requester_label_optional'              => 'Solicitante (Opcional):',
    'assignee_label_optional'               => 'Responsável (Atribuído Para):', // Removido "Opcional" para ser consistente com o filtro
    'helpdesk_link_label_optional'          => 'Link do Helpdesk (Opcional):',
    'internal_notes_label_optional'         => 'Notas Internas (Opcional):',
    'new_task'                              => 'Nova Tarefa',
    'edit_task'                             => 'Editar Tarefa',
    'view_task'                             => 'Detalhes da Tarefa',
    'no_tasks_found'                        => 'Nenhuma tarefa encontrada.',
    'comments'                              => 'Comentários',
    'add_new_comment'                       => 'Adicionar Novo Comentário',
    'your_comment_label'                    => 'Seu Comentário:',
    'send_comment'                          => 'Enviar Comentário',
    'no_comments_yet'                       => 'Nenhum comentário ainda.',
    'tasks_start_delivery_header'           => 'Tarefas (Início/Entrega)', // Para header da tabela de sprints

    //--------------------------------------------------------------------------
    // Systems (Sistemas)
    //--------------------------------------------------------------------------
    'systems'                               => 'Sistemas',
    'system'                                => 'Sistema', // Singular
    'system_name_label'                     => 'Nome do Sistema:',
    'new_system'                            => 'Novo Sistema',
    'edit_system'                           => 'Editar Sistema',
    'view_system'                           => 'Detalhes do Sistema',
    'no_systems_found'                      => 'Nenhum sistema cadastrado.',
    'modules_associated_to_system_short'    => 'Módulos', // Header curto para tabela de sistemas
    'tasks_associated_to_system_short'      => 'Tarefas', // Header curto para tabela de sistemas
    'modules_associated_to_system'          => 'Módulos Associados a este Sistema',
    'no_modules_for_system'                 => 'Nenhum módulo associado a este sistema.',
    'tasks_associated_to_system'            => 'Tarefas Associadas a este Sistema',


    //--------------------------------------------------------------------------
    // Modules (Módulos)
    //--------------------------------------------------------------------------
    'modules'                               => 'Módulos',
    'module'                                => 'Módulo', // Singular
    'module_name_label'                     => 'Nome do Módulo:',
    'system_associated_label'               => 'Sistema Associado:', // Removido "Opcional" para ser consistente
    'system_associated_label_optional'      => 'Sistema Associado (Opcional):', // Para formulários
    'new_module'                            => 'Novo Módulo',
    'edit_module'                           => 'Editar Módulo',
    'view_module'                           => 'Detalhes do Módulo',
    'no_modules_found'                      => 'Nenhum módulo cadastrado.',
    'no_system_global_module'               => 'N/D (Módulo Global)',
    'tasks_associated_to_module'            => 'Tarefas Associadas a este Módulo', // Também para header de tabela
    'no_tasks_for_module'                   => 'Nenhuma tarefa associada a este módulo.',
    'new_task_for_module'                   => 'Nova Tarefa para este Módulo',
    'back_to_system'                        => 'Voltar para o Sistema',
    'new_module_for_system'                 => 'Novo Módulo para este Sistema',
    'for_this_system'                       => 'para este sistema', // para msg "nenhum módulo para este sistema"


    //--------------------------------------------------------------------------
    // Sprints
    //--------------------------------------------------------------------------
    'sprints'                               => 'Sprints',
    'sprint'                                => 'Sprint', // Singular
    'sprint_name_label'                     => 'Nome da Sprint:',
    'start_date_label_optional'             => 'Data de Início (Opcional):',
    'end_date_label_optional'               => 'Data de Fim (Opcional):',
    'quarter_associated_label_optional'     => 'Trimestre/Semestre Associado (Opcional):',
    'new_sprint'                            => 'Nova Sprint',
    'edit_sprint'                           => 'Editar Sprint',
    'view_sprint'                           => 'Detalhes da Sprint',
    'no_sprints_found'                      => 'Nenhuma sprint cadastrada.',
    'tasks_starting_in_sprint'              => 'Tarefas com Início nesta Sprint',
    'no_tasks_starting_in_sprint'           => 'Nenhuma tarefa programada para iniciar nesta sprint.',
    'tasks_delivering_in_sprint'            => 'Tarefas com Entrega nesta Sprint',
    'no_tasks_delivering_in_sprint'         => 'Nenhuma tarefa programada para entrega nesta sprint.',
    'back_to_quarter'                       => 'Voltar para o Trimestre/Semestre',
    'new_sprint_for_quarter'                => 'Nova Sprint para este Período',
    'for_this_period'                       => 'para este período', // para msg "nenhuma sprint para este período"


    //--------------------------------------------------------------------------
    // Autenticação (Breeze deve cobrir a maioria, mas algumas podem ser úteis)
    //--------------------------------------------------------------------------
    'login'                                 => 'Entrar',
    'logout'                                => 'Sair',
    'register'                              => 'Registrar',
    'profile'                               => 'Perfil',
    'email_address'                         => 'Endereço de E-mail',
    'password'                              => 'Senha',
    'remember_me'                           => 'Lembrar-me',
    'forgot_password'                       => 'Esqueceu sua senha?',

];