<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ChunkController;

use App\Http\Controllers\Admin\FormTvController;
use App\Http\Controllers\Admin\DocumentTvController;


use App\Http\Controllers\media\MediaController;

use App\Http\Controllers\media\Api\MediaApiController;

use App\Http\Controllers\SetingsController;

use App\Http\Controllers\InstallController;

use App\Http\Controllers\ResetController;//testing controller reset install


/*Route::get('/', function () {
    return view('welcome');
});*/



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//install cms route start

Route::prefix('install')->controller(InstallController::class)->group(function () {
    Route::get('/', 'welcome')->name('install.welcome');
    Route::get('/requirements', 'requirements')->name('install.requirements');
    Route::get('/database', 'database')->name('install.database');
    Route::post('/database', 'testDatabase')->name('install.database.test');
    Route::get('/admin', 'admin')->name('install.admin');
    Route::post('/admin', 'setupAdmin')->name('install.admin.setup');
    Route::get('/complete', 'complete')->name('install.complete');
});


if (!file_exists(storage_path('installed'))) {
    Route::get('/{any}', function () {
        return redirect('/install');
    })->where('any', '.*');
}
Route::get('/reset-install', [ResetController::class, 'resetInstallation']);
//install cms route end







Route::middleware(['auth', 'permission:admin.access'])->group(function () {
    //adminstart
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    //Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    //documents
    // Список документов (админка)
    Route::get('/admin/documents', [DocumentController::class, 'index'])->name('documents.index');
    // Страница создания документа
    Route::get('/admin/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    // Сохранение нового документа
    Route::post('/admin/documents/store', [DocumentController::class, 'store'])->name('documents.store');
    // Страница редактирования документа
    Route::get('/admin/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    // Обновление документа
    Route::put('/admin/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');
    // Удаление документа
    Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::post('/admin/documents/reorder', [DocumentController::class, 'reorder'])->name('documents.reorder');
    
    // список шаблонов
    Route::get('/admin/templates', [TemplateController::class, 'index'])->name('templates.index')->middleware('permission:template.read');
    Route::get('/admin/templates/create', [TemplateController::class, 'create'])->name('templates.create')->middleware('permission:template.create');
    Route::post('/admin/templates/store', [TemplateController::class, 'store'])->name('templates.store')->middleware('permission:template.create');
    Route::delete('/admin/templates/{id}', [TemplateController::class, 'destroy'])->name('templates.destroy')->middleware('permission:template.delete');
    Route::get('/admin/templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit')->middleware('permission:template.update');
    Route::put('/admin/templates/{id}', [TemplateController::class, 'update'])->name('templates.update')->middleware('permission:template.update');



    // Управление ролями
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:roles.read');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:roles.create');
    Route::post('/admin/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:roles.create');
    Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');//->middleware('permission:roles.update');
    Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->name('roles.update');//->middleware('permission:roles.update');
    Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:roles.delete');


    // Cunks
    Route::get('/admin/chunks', [ChunkController::class, 'index'])->name('chunks.index')->middleware('permission:chunk.read');
    Route::get('/admin/chunks/create', [ChunkController::class, 'create'])->name('chunks.create')->middleware('permission:chunk.create');
    Route::post('/admin/chunks/store', [ChunkController::class, 'store'])->name('chunks.store')->middleware('permission:chunk.create');
    Route::delete('/admin/chunks/{id}', [ChunkController::class, 'destroy'])->name('chunks.destroy')->middleware('permission:chunk.delete');
    Route::get('/admin/chunks/{id}/edit', [ChunkController::class, 'edit'])->name('chunks.edit')->middleware('permission:chunk.update');
    Route::put('/admin/chunks/{id}', [ChunkController::class, 'update'])->name('chunks.update')->middleware('permission:chunk.update');

    //tv 
    Route::get('/admin/tvs', [FormTvController::class, 'index'])->name('tvs.index')->middleware('permission:tvs.read');
    Route::get('/admin/tvs/create', [FormTvController::class, 'create'])->name('tvs.create')->middleware('permission:tvs.create');
    Route::post('/admin/tvs/store', [FormTvController::class, 'store'])->name('tvs.store')->middleware('permission:tvs.create');
    Route::get('/admin/tvs/{id}/edit', [FormTvController::class, 'edit'])->name('tvs.edit')->middleware('permission:tvs.update');
    Route::put('/admin/tvs/{id}', [FormTvController::class, 'update'])->name('tvs.update')->middleware('permission:tvs.update');
    Route::delete('/admin/tvs/{id}', [FormTvController::class, 'destroy'])->name('tvs.destroy')->middleware('permission:tvs.delete');

    Route::get('/admin/form-tvs/{id}', function ($id) {
        $formTv = \App\Models\FormTv::findOrFail($id);
        return response()->json($formTv);
    });

    Route::post('/admin/document-tvs', [DocumentTvController::class, 'store'])
    ->name('document-tvs.store');
    Route::get('/admin/document-tvs/{tvId}/edit', [DocumentTvController::class, 'editTv'])
    ->name('document-tvs.editTv');
    Route::put('/admin/document-tvs/{tv}', [DocumentTvController::class, 'update'])
    ->name('document-tvs.update');
    Route::delete('/admin/document-tvs/{id}', [DocumentTvController::class, 'destroy'])->name('document-tvs.destroy');

    //media
    Route::get('/admin/media', [MediaController::class, 'index'])->name('media.index')->middleware('permission:roles.read');
    Route::post('/admin/create-folder', [MediaApiController::class, 'createFolder']);
    Route::post('/admin/delete-folder', [MediaApiController::class, 'deleteFolder']);
    Route::post('/admin/upload-file', [MediaApiController::class, 'uploadFile']);
    Route::get('/admin/media/tree', [MediaApiController::class, 'tree']);

    // Пользователи
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:users.read');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users.delete');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.update');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('permission:users.update');

    Route::get('/admin/setings', [SetingsController::class, 'index'])->name('setings')->middleware('permission:settings.read');
    Route::post('/admin/setings/locale', [SetingsController::class, 'setLocale'])->name('settings.setLocale')->middleware('permission:settings.update');

    Route::post('/settings/set-home', [SetingsController::class, 'setHome'])
    ->name('settings.setHome');

    //end admin


});

Route::get('/', [DocumentController::class, 'home'])->name('home');

Route::get('/{path}', [DocumentController::class, 'show'])
    ->where('path', '.*')
    ->name('documents.show');