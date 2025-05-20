<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Importe os controllers que você criou
use App\Http\Controllers\QuarterController;
use App\Http\Controllers\MainObjectiveController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCommentController; // Se for gerenciado como recurso principal

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('quarters', QuarterController::class);
Route::resource('main-objectives', MainObjectiveController::class);
Route::resource('features', FeatureController::class);
Route::resource('systems', SystemController::class);
Route::resource('modules', ModuleController::class);
Route::resource('sprints', SprintController::class);
Route::resource('tasks', TaskController::class);
Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store'])->name('tasks.comments.store');
Route::resource('task-comments', TaskCommentController::class)->except(['index', 'show']);


// Se você tiver um dashboard simples (crie a view em resources/views/dashboard.blade.php)
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


// Lembre-se: Quando você decidir adicionar autenticação, poderá agrupar estas rotas:
/*
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); // Exemplo de rota que necessita de autenticação

    Route::resource('quarters', QuarterController::class);
    Route::resource('main-objectives', MainObjectiveController::class);
    // ... e as outras rotas de recurso
});
*/

// Se estiver usando o Laravel Breeze ou Jetstream, eles já configuram rotas de autenticação.
// Ex: require __DIR__.'/auth.php'; (para Breeze)