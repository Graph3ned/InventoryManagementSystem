<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

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

Route::get('/test-pagination', function () {
    $reports = new App\Livewire\Reports();
    $reports->mount();
    $paginated = $reports->getPaginatedDailySales();
    
    return response()->json([
        'total' => $paginated['total'],
        'current_page' => $paginated['current_page'],
        'per_page' => $paginated['per_page'],
        'last_page' => $paginated['last_page'],
        'data_count' => $paginated['data']->count(),
        'should_show_pagination' => $paginated['total'] > $paginated['per_page'],
        'sales_count' => $reports->sales->count()
    ]);
});

require __DIR__.'/auth.php';
