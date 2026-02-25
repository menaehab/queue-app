<?php

use App\Http\Controllers\ProfileController;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // dispatch(new \App\Jobs\LogInfoJob())->onQueue('log_info');

    $user = User::first();

    dispatch(new SendWelcomeEmail($user))->onQueue('emails');

    Bus::batch([
        new \App\Jobs\JobBatch1(),
        new \App\Jobs\JobBatch2(),
    ])->dispatch();
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
