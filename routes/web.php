<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function() {
    Route::view('profile', 'profile')
        ->name('profile');

    Route::view('carros/create', 'carros.create')
        ->name('carros.create');
    Route::view('carros/edit/{id}', 'carros.edit')
        ->name('carros.edit');

    Route::view('locacoes/create/{id}', 'locacoes.create')
        ->name('locacoes.create');
    Route::view('locacoes', 'locacoes.show')
        ->name('locacoes.show');
});





require __DIR__ . '/auth.php';
