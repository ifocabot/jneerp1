<?php

use App\Http\Controllers\erpController;
use App\Http\Controllers\oddoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


route::middleware(['auth','role:super_admin,admin,management'])->group(function(){
    route::get('/erp',[erpController::class,'index'])->name('erp.dashboard');
    route::get('/erp/oddohistory',[erpController::class,'oddoHistoryview'])->name('oddo.history');
    route::get('/erp/vehicles',[erpController::class,'vehiclesview'])->name('oddo.vehicles');
    route::get('/erp/vehiclesajax',[erpController::class,'vehiclesAjax'])->name('oddo.vehicles.data');
    route::get('/erp/oddohistoryajax',[erpController::class,'oddoHistoryAjax'])->name('oddo.history.data');
});

route::middleware(['auth','role:user'])->group(function(){
    route::get('/app',[userController::class,'index']);
    route::get('/app/oddoOption',[oddoController::class,'index'])->name('oddoOption');
    route::get('/app/oddoOutView',[oddoController::class,'addOddoOut'])->name('oddoOutView');
    route::post('/app/oddoOutPost',[oddoController::class,'oddoOutPost'])->name('oddoOutPost');
    route::get('/app/oddoInView',[oddoController::class,'addOddoIn'])->name('oddoInView');
    route::post('/app/oddoInPost',[oddoController::class,'oddoInPost'])->name('oddoInPost');

});


require __DIR__.'/auth.php';

