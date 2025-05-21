<?php

use Illuminate\Support\Facades\Route;

// Importe os controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuarterController;
use App\Http\Controllers\MainObjectiveController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\ProfileController; // Controller do Breeze para o perfil

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas que exigem autenticação
// O middleware 'auth' garantirá que, se o usuário não estiver logado,
// ele será redirecionado para a rota nomeada 'login'.
// O middleware 'verified' é opcional, mas recomendado se você usar verificação de e-mail.
Route::middleware(['auth'])->group(function () {
    // A rota raiz agora está protegida. Se não logado, redireciona para /login.
    // Se logado, mostra o DashboardController.
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de Perfil (gerenciadas pelo Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Suas rotas de recursos
    Route::resource('quarters', QuarterController::class);
    Route::resource('main-objectives', MainObjectiveController::class);
    Route::resource('features', FeatureController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('systems', SystemController::class);
    Route::resource('modules', ModuleController::class);
    Route::resource('sprints', SprintController::class);

    Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store'])->name('tasks.comments.store');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Rotas de autenticação (login, registro, logout, etc.)
// Esta linha é adicionada pelo Laravel Breeze e inclui todas as rotas necessárias para autenticação.
// Geralmente fica no final do arquivo.
require __DIR__.'/auth.php';

