<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->nullable()->constrained('features')->onDelete('cascade');
            $table->foreignId('system_id')->nullable()->constrained('systems')->onDelete('set null');
            $table->foreignId('module_id')->nullable()->constrained('modules')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('estimated_hours', 10, 2)->nullable();
            $table->enum('task_type', ['Bug', 'Melhoria', 'Nova Funcionalidade', 'Débito Técnico', 'Pesquisa']);
            $table->enum('priority', ['Baixa', 'Média', 'Alta', 'Crítica']);
            $table->foreignId('start_sprint_id')->nullable()->constrained('sprints')->onDelete('set null');
            $table->foreignId('delivery_sprint_id')->nullable()->constrained('sprints')->onDelete('set null');
            $table->enum('status', ['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído', 'Em Testes', 'Bloqueada', 'Cancelada'])->default('Não Iniciado');
            $table->foreignId('requester_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assignee_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('helpdesk_link')->nullable();
            $table->text('notes')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
