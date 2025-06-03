<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('carros/create', 'carros.create')
    ->middleware(['auth'])
    ->name('carros.create');

Route::view('carros/edit/{id}', 'carros.edit')
    ->middleware(['auth'])
    ->name('carros.edit');


require __DIR__ . '/auth.php';
