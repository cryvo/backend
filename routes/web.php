<?php
// routes/web.php
Route::get('2fa',   [App\Http\Controllers\Auth\TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('2fa',  [App\Http\Controllers\Auth\TwoFactorController::class, 'store'])->name('2fa.post');

// routes/web.php
Route::middleware('auth')->group(function(){
  Route::get('2fa/google',  [App\Http\Controllers\Auth\Google2FAController::class, 'index'])->name('2fa.google.index');
  Route::post('2fa/google', [App\Http\Controllers\Auth\Google2FAController::class, 'verify'])->name('2fa.google.verify');
});
// routes/web.php
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\LandingController;

// Public landing pages
Route::get('/{slug}', [LandingController::class,'show'])->name('landing.show');

// Admin CMS (requires “admin” role)
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function(){
    Route::resource('pages', PageController::class);
});
