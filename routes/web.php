<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Guest\ProjectController as GuestProjectController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController as AdminHomeController;

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

// Rotta per gli utenti visitatori
Route::get('/', GuestHomeController::class)->name('guest.home');

Route::get('/projects/{slug}', [GuestProjectController::class, 'show'])->name('guest.projects.show');

// Rotte per l'amministratore

//* OPZIONE 1 (no grouping)
// Route::get('/admin', AdminHomeController::class)->middleware(['auth'])->name('admin.home');
// Route::get('/admin/projects', [ProjectController::class, 'index'])->name('admin.projects.index')->middleware('auth');
// Route::get('/admin/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create')->middleware('auth');
// Route::get('/admin/projects/{project}', [ProjectController::class, 'show'])->name('admin.projects.show')->middleware('auth');
// Route::post('/admin/projects', [ProjectController::class, 'store'])->name('admin.projects.store')->middleware('auth');
// Route::get('/admin/projects/{project}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit')->middleware('auth');
// Route::put('/admin/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update')->middleware('auth');
// Route::delete('/admin/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy')->middleware('auth');

//* OPZIONE 2 (grouping)
Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function () {

    //# ROTTA ADMIN HOME
    Route::get('', AdminHomeController::class)->middleware(['auth'])->name('.home');

    //# ROTTE SOFT DELETE
    Route::get('/projects/trash', [AdminProjectController::class, 'trash'])->name('projects.trash');
    Route::patch('/projects/{project}/restore', [AdminProjectController::class, 'restore'])->name('projects.restore')->withTrashed();
    Route::delete('/projects/{project}/drop', [AdminProjectController::class, 'drop'])->name('projects.drop')->withTrashed();

    //# ROTTE ADMIN PROJECTS - OPZIONE 1
    // Route::get('/projects', [ProjectController::class, 'index'])->name('.projects.index');
    // Route::get('/projects/create', [ProjectController::class, 'create'])->name('.projects.create');
    // Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('.projects.show');
    // Route::post('/projects', [ProjectController::class, 'store'])->name('.projects.store');
    // Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('.projects.edit');
    // Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('.projects.update');
    // Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('.projects.destroy');

    //# ROTTE ADMIN PROJECTS - OPZIONE 2
    //! RIASSUNTO DA RIGA 41 A RIGA 47 CON UNA SOLA ROTTA CHE SOTTOBANCO GESTISCE LE ROTTE DI CUI SOPRA
    //! PER VERIFICARE -> php artisan route:list
    Route::resource('projects', AdminProjectController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->withTrashed();
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->withTrashed();
});

require __DIR__ . '/auth.php';
