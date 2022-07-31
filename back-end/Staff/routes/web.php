<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemOrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;

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
    return view('welcome');
});
//orders
Route::get('/orders', [OrderController::class, "index"])->name("order.index");
Route::match(['put', 'patch'], '/orders/{id}', [OrderController::class, "update"])->name("order.update");

//order details
Route::get('/order-details/{id}', [ItemOrderController::class, "show"])->name("order_details.show");

//payments
// Route::get('/payments', [PaymentController::class, "index"])->name("payment.index");
Route::get('/payments/{id}', [PaymentController::class, "show"])->name("payment.show");

//reservations
Route::get('/reservations/create', [ReservationController::class, "create"])->name("reservations.create");
Route::get('/reservations', [ReservationController::class, "index"])->name("reservations.index");
Route::match(['put', 'patch'], '/reservations/{id}', [ReservationController::class, "update"])->name("reservations.update");
Route::delete('/reservations/{id}', [ReservationController::class, "destroy"])->name("reservations.destroy");
Route::post('/reservations', [ReservationController::class, "store"])->name("reservations.store");

//customer
Route::get('/customers/create', [CustomerController::class, "create"])->name("customers.create");
Route::post('/customers', [CustomerController::class, "store"])->name("customers.store");

//auth
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
