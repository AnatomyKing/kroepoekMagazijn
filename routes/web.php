<?php

use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home-producten');
    }
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Voor alle ingelogde gebruikers
    Route::inertia('/home-producten', 'components/magazijn/HomeProducten/HomeProducten')->name('home-producten');
    Route::inertia('/mijn-reserveringen', 'components/magazijn/MijnReserveringen/MijnReserveringen')->name('mijn-reserveringen');

    // Alleen admin
    Route::middleware(['role:admin'])->group(function () {
        Route::inertia('/admin-producten-beheer', 'components/magazijn/AdminProductenBeheer/AdminProductenBeheer')->name('admin-producten-beheer');
        Route::inertia('/admin-reserveringen', 'components/magazijn/AdminReserveringen/AdminReserveringen')->name('admin-reserveringen');

        // API endpoints voor admin
        Route::get('/api/admin/reservations', [BorrowingController::class, 'index']);
        Route::delete('/api/admin/reservations/{id}', [BorrowingController::class, 'destroy']);
    });

    // Voor alle ingelogde gebruikers (ook admin) – maar admin ziet meer
    Route::get('/api/items', [ProductController::class, 'index']); // home producten
    Route::get('/api/my-reservations', [BorrowingController::class, 'userReservations']);
    Route::post('/borrowings', [BorrowingController::class, 'store']);
    Route::post('/borrowings/{id}/return', [BorrowingController::class, 'returnItem']);
});


require __DIR__ . '/settings.php';
