<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard');

Route::view('InventoryManagement', 'InventoryManagement')
    ->middleware(['auth', 'verified'])
    ->name('InventoryManagement');

Route::view('Sales', 'Sales')
    ->middleware(['auth', 'verified'])
    ->name('Sales');

Route::view('Reports', 'Reports')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('Reports');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('Staffs', 'Staffs')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('Staffs');

require __DIR__.'/auth.php';
