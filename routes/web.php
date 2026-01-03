<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Install\InstallController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\Template\TemplateController;
use App\Http\Controllers\TvForm\TvFormController;
use App\Http\Controllers\Api\Media\MediaController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('install')->controller(InstallController::class)->group(function () {
    Route::get('/', 'welcome')->name('install.welcome');
    Route::get('/requirements', 'requirements')->name('install.requirements');
    Route::get('/database', 'database')->name('install.database');
    Route::post('/database', 'testDatabase')->name('install.database.test');
    Route::get('/admin', 'admin')->name('install.admin');
    Route::post('/admin', 'setupAdmin')->name('install.admin.setup');
    Route::get('/complete', 'complete')->name('install.complete');
});

Route::middleware(['auth', 'permission:admin.access'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/admin/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/admin/documents/store', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/admin/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::post('/admin/documents/sort', [DocumentController::class, 'updateOrder'])->name('documents.sort');
    Route::put('/admin/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    /* templates rute */
    Route::get('/admin/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/admin/templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('/admin/templates/store', [TemplateController::class, 'store'])->name('templates.store');
    Route::get('/admin/templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/admin/templates/{id}', [TemplateController::class, 'update'])->name('templates.update');
    Route::delete('/admin/templates/{id}', [TemplateController::class, 'destroy'])->name('templates.destroy');


    Route::get('/admin/tv_forms', [TvFormController::class, 'index'])->name('tv_forms.index');
    Route::get('/admin/tv_forms/create', [TvFormController::class, 'create'])->name('tv_forms.create');
    Route::post('/admin/tv_forms/store', [TvFormController::class, 'store'])->name('tv_forms.store');
    Route::get('/admin/tv_forms/{id}/edit', [TvFormController::class, 'edit'])->name('tv_forms.edit');
    Route::put('/admin/tv_forms/{tvForm}', [TvFormController::class, 'update'])->name('tv_forms.update');
    Route::delete('/admin/tv_forms/{id}', [TvFormController::class, 'destroy'])->name('tv_forms.destroy');

    Route::get('/admin/media', [MediaController::class, 'index'])
    ->name('media.index');
    Route::get('/media/folders', [MediaController::class, 'media_folder']);
    Route::get('/media/files', [MediaController::class, 'media_files']);

});

Route::get('/{path?}', [DocumentController::class, 'show'])
    ->where('path', '.*')
    ->name('document.show');