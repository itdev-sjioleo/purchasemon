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
    Route::get('/', function () {
        return redirect('/view2');
    });
    Route::get('/view1', 'App\Http\Controllers\MainController@index');
    Route::get('/view2', 'App\Http\Controllers\MainController@view2');
    Route::get('/summary', 'App\Http\Controllers\MainController@summary');
    Route::get('detail/{pr_id}', 'App\Http\Controllers\MainController@detail');
    Route::get('master-datatable', 'App\Http\Controllers\MainController@datatable');
    Route::get('summary-datatable', 'App\Http\Controllers\MainController@summaryDatatable');
    Route::get('master-export', 'App\Http\Controllers\MainController@export');
    Route::get('summary-export', 'App\Http\Controllers\MainController@summaryExport');
    Route::get('auth-log', 'App\Http\Controllers\MainController@authLog');
    Route::get('auth-log-datatable', 'App\Http\Controllers\MainController@datatableAuthLog');
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


