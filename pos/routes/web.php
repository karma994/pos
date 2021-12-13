<?php

use App\Http\Controllers\Master\BranchController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Stock\CategoryController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Stock\UnitofMeasurementController;
use App\Http\Controllers\Sales\SaleController;
use App\Http\Controllers\Sales\CustomersaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\UserManagement\PermissionController;
use App\Http\Controllers\UserManagement\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/branches', BranchController::class);
    Route::resource('/departments', DepartmentController::class);
    Route::resource('/stocks', StockController::class);
    Route::resource('/categories', CategoryController::class);
   
    Route::resource('/uom', UnitofMeasurementController::class);
    Route::resource('/sale', SaleController::class);
    Route::resource('/cs', CustomersaleController::class);

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/details/{barcode}', [SaleController::class, 'details']);
Route::get('/updateStock/{productList}', [StockController::class, 'update']);
Route::get('/refund/{product}', [CustomersaleController::class, 'refund']);
Route::get('/addsale/{saleinfo}', [CustomersaleController::class, 'addsaleinfo']);
Route::get('/csale/{details}', [SaleController::class, 'salerecord']);
Route::get('/deletebranch/{id}', [BranchController::class, 'destroy']);
Route::get('/deletedepartment/{id}', [DepartmentController::class, 'destroy']);
Route::get('/deleterole/{id}', [RoleController::class, 'destroy']);
Route::get('/deleteuser/{id}', [UserController::class, 'destroy']);
Route::get('/checkuser/{email}', [UserController::class, 'checkuser']);
Route::get('/deletestock/{id}', [StockController::class, 'destroy']);
Route::get('/deletecategory/{id}', [CategoryController::class, 'destroy']);
Route::get('/deleteumo/{id}', [UnitofMeasurementController::class, 'destroy']);
Route::get('/accounts', [CustomersaleController::class, 'accounts']);
Route::get('/checkcatname/{name}', [CategoryController::class, 'checkcatname']);
Route::get('/checkunitname/{unit}', [UnitofMeasurementController::class, 'checkuname']);
Route::get('/checkbranchname/{branch}', [BranchController::class, 'checkbranch']);
Route::get('/checkdepartmentname/{department}', [DepartmentController::class, 'checkdepartment']);