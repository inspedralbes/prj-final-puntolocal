<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\ClienteController;
    use App\Http\Controllers\CategoriaGeneralController;
    use App\Http\Controllers\ComercioController;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');


    // ==== USUARIOS ===================
    Route::prefix('auth')->group(function () {
        Route::post('register', [ClienteController::class, 'RegistrarCliente']);
        Route::post('login', [ClienteController::class, 'login']);
    });

    // ==== COMERCIOS ===================

    Route::middleware('auth:sanctum')->prefix('comercios')->group(function () {
        Route::post('/', [ComercioController::class, 'RegistrarComercio']);
        Route::get('/', [ComercioController::class, 'getComercios']);
        Route::get('/{id}', [ComercioController::class, 'getComercio']); 
    });

    // ==== CATEGORIAS GENERALES ===================
    Route::middleware('auth:sanctum')->prefix('categoriasGenerales')->group(function () {
        Route::get('/', [CategoriaGeneralController::class, 'getCategoriasGenerales']);
    });