<?php

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

Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/', 'App\Http\Controllers\MainController@index');
    Route::get('main', 'App\Http\Controllers\MainController@index');
    Route::get('main-datatable', 'App\Http\Controllers\MainController@datatable');
    Route::get('main-export', 'App\Http\Controllers\MainController@export');
});

Auth::routes();

Route::get('test-reset-password', function() {
    return view('emails.reset-password');
});

Route::get('/test', function() {
    $data = App\Models\PurchaseOrder::with('PurchaseOrderItem')
        ->where('PONumber', 'SJIO/HO/PO/2303/001')
        ->first()
        ->toArray();
    dd($data);
});


