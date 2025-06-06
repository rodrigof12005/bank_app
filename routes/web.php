<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () { return view('login.login-view');});
Route::get('login', function () { return view('login.login-view');})->name('login');
Route::get('novo-cadastro', function () { return view('cadastro.cadastro-form');})->name('novo-cadastro');
Route::post('cadastrar', [UserController::class, 'cadastrarUsuario'])->name('cadastrar');
Route::post('logon', [LoginController::class, 'logon'])->name('logon');

Route::middleware('auth')->group(function () {
     Route::get('home', function () {return view('home.home-view');})->name('home');
     Route::get('novo-deposito', function () {return view('transations.depositar-form');})->name('novo-deposito');
     Route::post('logout', [LoginController::class, 'logout'])->name('logout');
     Route::post('depositar', [TransationController::class, 'depositar'])->name('depositar');
     Route::post('transferir', [TransationController::class, 'transferir'])->name('transferir');
     Route::get('nova-transferencia', function () {return view('transations.transferir-form');})->name('nova-transferencia');
    
    });


