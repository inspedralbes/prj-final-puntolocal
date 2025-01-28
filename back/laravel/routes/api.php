<?php
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ==== AUTH ===================
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'registrar']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->post('change-password', [AuthController::class, 'changePassword']);
});

// ==== CLIENTES ===================
Route::middleware('auth:sanctum')->prefix('cliente')->group(function () {
    Route::get('/{id}', [ClienteController::class, 'getCliente']);
    Route::put('/{id}/datos-personales', [ClienteController::class, 'updateDatosPersonales']);
    Route::put('/{id}/datos-facturacion', [ClienteController::class, 'updateDatosFacturacion']);
});

// ==== COMERCIOS ===================

Route::middleware('auth:sanctum')->prefix('comercios')->group(function () {
    Route::post('/', [ComercioController::class, 'RegistrarComercio']);
    Route::get('/', [ComercioController::class, 'getComercios']);
    Route::get('/{id}', [ComercioController::class, 'getComercio']);
});

// ==== CATEGORIAS ===================
Route::middleware('auth:sanctum')->prefix('categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index']);
});


Route::middleware('auth:sanctum')->prefix('producto')->group(function () {
    // Obtener todos los productos
    Route::get('/', [ProductoController::class, 'index']);

    // Crear un nuevo producto
    Route::post('/', [ProductoController::class, 'store']);

    // Obtener un producto específico
    Route::get('{id}', [ProductoController::class, 'show']);

    // Actualizar un producto específico
    Route::put('{id}', [ProductoController::class, 'update']);

    // Eliminar un producto específico
    Route::delete('{id}', [ProductoController::class, 'destroy']);
});

