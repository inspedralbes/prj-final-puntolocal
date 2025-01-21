<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\ClienteController;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');


    // ==== USUARIOS ===================
    Route::prefix('auth')->group(function () {
        Route::post('register', [ClienteController::class, 'RegistrarCliente']);
        Route::post('login', [ClienteController::class, 'login']);
    });