<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

# VOOR NU GEBRUIKTE ROUTES, HET LARAVEL PROJECT HEEFT NOG VEEL DEFAULT CODE WAT WEG MOET, MAAR DIT KOMT LATER BIJ EEN BIG CLEAN UP
# ZO VOOR KOMEN WE DAT ER ZO MIN MOGELIJK DINGEN BREKEN, WANT VOOR DE BACKEND IS SOMMIGE DEFAULT CODE NOG BRUIKBAAR

Route::get('/home-producten', function () {
    return view('home-producten');
})->name('home-producten');

Route::get('/mijn-reserveringen', function () {
    return view('mijn-reserveringen');
})->name('mijn-reserveringen');

Route::get('/admin-producten-beheer', function () {
    return view('admin-producten-beheer');
})->name('admin-producten-beheer');

Route::get('/admin-reserveringen', function () {
    return view('admin-reserveringen');
})->name('admin-reserveringen');



require __DIR__ . '/settings.php';
