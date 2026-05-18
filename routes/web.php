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

Route::inertia('/home-producten', 'components/magazijn/HomeProducten/HomeProducten')
    ->name('home-producten');

Route::inertia('/mijn-reserveringen', 'components/magazijn/MijnReserveringen/MijnReserveringen')
    ->name('mijn-reserveringen');

Route::inertia('/admin-producten-beheer', 'components/magazijn/AdminProductenBeheer/AdminProductenBeheer')
    ->name('admin-producten-beheer');

Route::inertia('/admin-reserveringen', 'components/magazijn/AdminReserveringen/AdminReserveringen')
    ->name('admin-reserveringen');



require __DIR__ . '/settings.php';
