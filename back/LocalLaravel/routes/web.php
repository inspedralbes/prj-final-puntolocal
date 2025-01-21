<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\VerificationController;

    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');