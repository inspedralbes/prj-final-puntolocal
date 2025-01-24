<?php
    use App\Http\Controllers\ProductoController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ClienteController;
    use App\Http\Controllers\SubcategoriaController;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');


    // ==== USUARIOS ===================
    Route::prefix('auth')->group(function () {
        Route::post('register', [ClienteController::class, 'RegistrarCliente']);
        Route::post('login', [ClienteController::class, 'login']);
    });


    Route::middleware('auth:sanctum')->prefix('producto')->group(function () {
        Route::post('crear', [ProductoController::class,'store']);
    });