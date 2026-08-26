<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/gigi', 'pages::gigi');
Route::livewire('/gigi2', 'pages::gigi2');
Route::livewire('/', 'pages::gigi');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
