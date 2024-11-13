<?php

use Illuminate\Support\Facades\Route;

Route::get('/',[App\Http\Controllers\HomeController::class,'index'])->name('/');
Route::middleware([])->group(__DIR__ . '/auth.php');
Route::middleware(['auth', 'io'])->group(__DIR__ . '/admin.php');


Route::get('change_role/{role}', function ($role) {
    session(['active_role' => $role]);
    return redirect()->back()->with('success', 'Akses Berhasil diubah menjadi ' . $role);
})->name('change_role');
