<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CnpjController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('login', 'login.form_login')->name('login');
Route::view('register', 'login.form_register')->name('register');
Route::post('auth', [LoginController::class, 'auth'])->name('login.auth');
Route::post('register', [LoginController::class, 'store'])->name('register.auth');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth'], 'prefix' => 'adm', 'as' => 'adm.'], function () {    

    Route::get('clientes', [ClienteController::class, 'index'])->name('clientes');
    Route::post('clientes', [ClienteController::class, 'store'])->name('cliente.store');
    Route::get('clientes/find/{slug}', [ClienteController::class, 'findBySlug'])->name('cliente.findBySlug');
    Route::get('clientes/form', [ClienteController::class, 'create'])->name('cliente.form');
    Route::put('clientes/{id}', [ClienteController::class, 'update'])->name('cliente.edit');
    Route::delete('clientes/{id}', [ClienteController::class, 'destroy'])->name('cliente.delete');

    Route::get('filiais/cliente/{id}', [CnpjController::class, 'findAllByClienteId'])->name('filiais.byCliente');
    Route::post('filiais/cliente/{id}', [CnpjController::class, 'store'])->name('filiais.store');
    Route::put('filiais/cliente/{id}', [CnpjController::class, 'update'])->name('filiais.edit');
});