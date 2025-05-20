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
        Schema::create('main_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quarter_id')->nullable()->constrained('quarters')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['Não Iniciado', 'Em Andamento', 'Pausado', 'Concluído', 'Aguardando Início'])->default('Aguardando Início');
            $table->foreignId('responsible_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_objectives');
    }
};
