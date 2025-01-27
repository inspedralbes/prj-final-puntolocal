<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ClienteController;
    use App\Http\Controllers\ProductoController;
    use App\Http\Controllers\ComercioController;
    use App\Http\Controllers\SubcategoriaController;
    use App\Http\Controllers\CategoriaGeneralController;

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
        Route::post('registerComercio', [ComercioController::class, 'RegistrarComercio']);
    });

    // ==== CATEGORIAS ===================
    Route::middleware('auth:sanctum')->prefix('categoriasGenerales')->group(function () {
        Route::get('getCategoriasGenerales', [CategoriaGeneralController::class, 'getCategoriasGenerales']);
    });

    // ==== PRODUCTO ====================    
    Route::prefix('producto')->group(function () {
        // Obtener todos los productos
        Route::get('/', [ProductoController::class, 'index']);

        // Obtener todos los productos de un comercio específico
        Route::get('comercio/{comercioID}', [ProductoController::class,'getByComercio']);

        // Obtener un producto específico
        Route::get('{id}', [ProductoController::class, 'show']);
    });


    Route::middleware('auth:sanctum')->prefix('producto')->group(function () {
        // Crear un nuevo producto
        Route::post('/', [ProductoController::class, 'store']);
        
        // Actualizar un producto específico
        Route::post('{id}',  [ProductoController::class, 'update']);
        
        // Eliminar un producto específico
        Route::delete('{id}', [ProductoController::class, 'destroy']);
    });

    // ==== SUBCATEGORIAS ===============
    Route::prefix('subcategorias')->group(function () {
        // Ver subcategorias
        Route::get('/{categoria_id}', [SubcategoriaController::class, 'show']);
    });