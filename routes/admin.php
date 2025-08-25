<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Posts Management
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/bulk-action', [AdminPostController::class, 'bulkAction'])->name('posts.bulk-action');

    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Admin Management (Super Admin only)
    Route::middleware('super_admin')->group(function () {
        Route::get('/admins', [AdminController::class, 'manageAdmins'])->name('admins.index');
        Route::post('/admins', [AdminController::class, 'createAdmin'])->name('admins.create');
        Route::put('/admins/{admin}', [AdminController::class, 'updateAdmin'])->name('admins.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'deleteAdmin'])->name('admins.delete');

        // Impersonation
        Route::post('/users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('users.impersonate');
        Route::post('/impersonate/stop', [AdminUserController::class, 'stopImpersonate'])->name('impersonate.stop');
    });
});
