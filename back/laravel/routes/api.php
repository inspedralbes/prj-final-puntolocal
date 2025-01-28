<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderComercioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\CategoriaController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ==== AUTH ===================
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'registrar']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// ==== CLIENTES ===================
Route::middleware('auth:sanctum')->prefix('cliente')->group(function () {
    Route::get('/{id}', [ClienteController::class, 'getCliente']);
    Route::put('/{id}', [ClienteController::class, 'updateCliente']);
});

// ==== COMERCIOS ===================
Route::middleware('auth:sanctum')->prefix('comercios')->group(function () {
    Route::post('/', [ComercioController::class, 'RegistrarComercio']);
    Route::get('/', [ComercioController::class, 'getComercios']);
    Route::get('/{id}', [ComercioController::class, 'getComercio']);
});

// ==== COMANDES ===================
Route::middleware('auth:sanctum')->prefix('comandes')->group(function () {
    // Obtener todas las comandas de un usuario
    Route::get('/', [OrderController::class, 'index']);

    // Crear un nueva comanda
    Route::post('/', [OrderController::class, 'store']);

    // Actualizar una comanda
    // Route::post('/{id}', [OrderController::class, 'update']);

    // Obtener una comanda específica
    Route::get('/{id}', [OrderController::class, 'show']);
});

// ==== COMANDES COMERCIOS ===================
Route::middleware('auth:sanctum')->prefix('admin/comandes')->group(function () {
    // Obtener todas las comandas de un comercio
    Route::get('/', [OrderComercioController::class, 'index']);

    // Obtener una comanda específica
    Route::get('/{id}', [OrderComercioController::class, 'show']);
    
    // Crear un nueva comanda
    Route::post('/', [OrderComercioController::class, 'store']);

    // Actualizar una comanda
    Route::post('/{id}', [OrderComercioController::class, 'update']);

});

// ==== CATEGORIAS ===================
Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index']);
});

// ==== SUBCATEGORIAS ===============
Route::prefix('subcategorias')->group(function () {
    Route::get('/{categoria_id}', [SubcategoriaController::class, 'show']);
});

// ==== PRODUCTO ====================
Route::prefix('producto')->group(function () {
    // Obtener todos los productos
    Route::get('/', [ProductoController::class, 'index']);

    // Obtener todos los productos de un comercio específico
    Route::get('comercio/{comercioID}', [ProductoController::class, 'getByComercio']);

    // Obtener un producto específico
    Route::get('{id}', [ProductoController::class, 'show']);
});

Route::middleware('auth:sanctum')->prefix('producto')->group(function () {
    // Crear un nuevo producto
    Route::post('/', [ProductoController::class, 'store']);

    // Actualizar un producto específico
    Route::post('{id}', [ProductoController::class, 'update']);

    // Eliminar un producto específico
    Route::delete('{id}', [ProductoController::class, 'destroy']);
});

// ==== SUBCATEGORIAS ===============
Route::prefix('subcategorias')->group(function () {
    // Ver subcategorias
    Route::get('/{categoria_id}', [SubcategoriaController::class, 'show']);
});

// ==== CLIENTES ====================
Route::middleware('auth:sanctum')->prefix('clientes')->group(function () {
    Route::get('{id}', [ClienteController::class, 'obtenerDatosCliente']);

    Route::get('{id}/compras', [OrderController::class, 'comprasCliente']);

    Route::get('compras/{id}', [OrderController::class, 'detalleCompra']);
});