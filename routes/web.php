<?php

use App\Http\Livewire\AsignarController;
use App\Http\Livewire\PosController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\PermisosController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('categories', CategoriesController::class);

Route::get('products', ProductsController::class);

Route::get('coins', CoinsController::class);

Route::get('pos', PosController::class);

Route::get('roles', RolesController::class);

Route::get('permisos', PermisosController::class);

Route::get('asignar', AsignarController::class);
