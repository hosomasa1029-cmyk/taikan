<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::redirect('/', '/dashboard')->name('home');

Route::get('dashboard', function () {
    return view('dashboard', [
        'header' => '体重管理アプリ',
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('records', function () {
        return view('records', [
            'header' => '記録',
        ]);
    })->name('records.index');

    Route::get('records/create', function () {
        return view('records', [
            'header' => '記録の作成',
        ]);
    })->name('records.create');

    Route::get('reports', function () {
        return view('reports', [
            'header' => 'レポート',
        ]);
    })->name('reports');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
});

require __DIR__ . '/auth.php';
