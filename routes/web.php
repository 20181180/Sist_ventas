<?php

use App\Models\Product;
use App\Http\Livewire\Informes;
use App\Http\Livewire\PosController;

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\CoinsController;

use App\Http\Livewire\RolesController;

use App\Http\Livewire\UsersController;

use App\Http\Livewire\AsignarController;

//use App\Http\Livewire\PermisosController;

use App\Http\Livewire\CashoutController;

use App\Http\Livewire\ReportsController;
use App\Http\Livewire\ClientesController;
use App\Http\Livewire\InformesController;
use App\Http\Livewire\PermisosController;

use App\Http\Livewire\ProductsController;

use App\Http\Controllers\ExportController;

use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\ProvedoresController;
use App\Http\Controllers\CotizacionController;
use App\Http\Livewire\Datos;
//use App\Http\Livewire\Header;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/home', [App\Http\Livewire\Header::class, 'render'])->name('home');
Route::middleware(['auth'])->group(function () {

    Route::get('categories', CategoriesController::class)->middleware('role:Admin');

    Route::get('products', ProductsController::class);

    Route::get('coins', CoinsController::class);

    Route::get('pos', PosController::class);

    Route::group(['middleware' => ['role:Admin']], function () {

        Route::get('roles', RolesController::class);

        Route::get('permisos', PermisosController::class);

        Route::get('asignar', AsignarController::class);

        Route::get('users', UsersController::class);
    });


    Route::get('Cort_de_caja', CashoutController::class);

    Route::get('reports', ReportsController::class);


    //rutas PDF
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);

    //rutas de reportes Excel
    Route::get('report/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reporteExcel']);
    Route::get('report/excel/{user}/{type}', [ExportController::class, 'reporteExcel']);

    Route::get('cotizacion/pdf/{total}/{items}/{points}', [CotizacionController::class, 'reportPDF']);
    Route::get('uwu/pdf/{idventa}/{total}/{items}', [PosController::class, 'printTicket']);
    Route::get('inventory/pdf', [ProductsController::class, 'GeneratePDF']);
    Route::get('catalogo/pdf', [InformesController::class, 'catalogoP_PDF']);
    Route::get('produc_baj/pdf', [InformesController::class, 'GeneratePDF']);



    Route::get('informes', InformesController::class);
    Route::get('datos', Datos::class);
    //Route::get(Header::class);
});
Route::get('pdf/reportventa/', function () {
    return view('reportventa');
});

Route::get('proxd', ProvedoresController::class);
Route::get('Client', ClientesController::class);
