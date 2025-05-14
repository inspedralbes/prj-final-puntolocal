<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CiudadesController;
use App\Http\Controllers\ProvinciasController;
use App\Http\Controllers\EstatCompraController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\OrderComercioController;
use App\Http\Controllers\ComercioFavoritosController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\RatingController;

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
    Route::get('/check-auth', [ClienteController::class, 'checkUser']);
    Route::get('/{id}', [ClienteController::class, 'getCliente']);
    Route::put('/{id}/datos-personales', [ClienteController::class, 'updateDatosPersonales']);
    Route::put('/{id}/datos-facturacion', [ClienteController::class, 'updateDatosFacturacion']);
    Route::get('/{id}/favoritos', [FavoritoController::class, 'index']);
    Route::post('/{id}/favoritos', [FavoritoController::class, 'toggleFavorito']);
    Route::get('/{id}/favoritos-info', [FavoritoController::class, 'getFavoritosInformacion']);
});

Route::prefix('comercios')->group(function () {
    Route::get('/{id}', [ComercioController::class, 'getComercio']);
    Route::get('/{id}/productos', [ComercioController::class, 'getProductosComercio']);
});

// ==== COMERCIOS ===================
Route::middleware('auth:sanctum')->prefix('comercios')->group(function () {
    Route::post('/', [ComercioController::class, 'RegistrarComercio']);
    Route::get('/', [ComercioController::class, 'getComercios']);
    Route::get('/{id}/check', [ComercioController::class, 'checkUserHasComercio']);
    Route::put('/{id}', [ComercioController::class, 'updateComercio']);
    Route::post('/{id}/imagenes', [ComercioController::class, 'updateComercioImagenes']);
    Route::delete('/{id}/imagenes', [ComercioController::class, 'deleteComercioImagen']);
});

Route::middleware('auth:sanctum')->prefix('favoritos')->group(function () {
    Route::get('/comercios-favoritos', [ComercioFavoritosController::class, 'index']);
    Route::post('/like/{id}', [ComercioFavoritosController::class, 'afegirLikeComerci']);
    Route::get('/verificar-seguido/{id}', [ComercioFavoritosController::class, 'verificarSeguido']);
});

Route::prefix('comercios')->group(function () {
    Route::get('/{id}', [ComercioController::class, 'getComercio']);
    Route::get('/search/{search}', [ComercioController::class, 'search']);
    Route::get('/getUserid/{id}', [ComercioController::class, 'getUserID']);
    Route::get('/comercios-cercanos/{latitud}/{longitud}', [ComercioController::class, 'getComerciosCercanos']);
    Route::get('/{id}/ratings', [RatingController::class, 'getComercioRatings']);
});

Route::get('/getLocations', [ComercioController::class, 'getLocations']);
Route::middleware('auth:sanctum')->post('/ratings', [RatingController::class, 'store']);

// ==== COMANDES ===================
Route::middleware('auth:sanctum')->prefix('comandes')->group(function () {
    // Obtener todas las comandas de un usuario
    Route::get('/', [OrderController::class, 'index']);

    // Crear un nueva comanda
    Route::post('/', [OrderController::class, 'store']);

    // Obtener ordenes de comercios a partir de una orden general
    Route::get('/{id}/suborders', [OrderController::class, 'showOrdersComercios']);

    // Obtener una comanda específica
    Route::get('/{id}', [OrderController::class, 'show']);

    // Ver información subcomanda del cliente
    Route::get('/suborder/{id}', [OrderComercioController::class, 'showData']);
});

// ==== SUBCOMANDES ===================
Route::middleware('auth:sanctum')->prefix('suborders')->group(function () {
    // Crear un nueva subcomanda
    Route::post('/', [OrderComercioController::class, 'store']);
});

// ==== COMANDES COMERCIOS ===================
Route::middleware('auth:sanctum')->prefix('admin/comandes')->group(function () {
    // Obtener todas las comandas activas de un comercio
    Route::get('/', [OrderComercioController::class, 'index']);

    Route::get('/historial', [OrderComercioController::class, 'historialOrders']);

    // Obtener una comanda específica
    Route::get('/{id}', [OrderComercioController::class, 'show']);

    // Crear un nueva comanda
    Route::post('/', [OrderComercioController::class, 'store']);

    // Actualizar una comanda
    Route::post('/{id}', [OrderComercioController::class, 'update']);
});


// ==== ESTATS ===================
Route::prefix('admin/estats')->group(function () {
    // Obtener todos los estados que puede tener un pedido
    Route::get('/', [EstatCompraController::class, 'index']);
});


Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

// Route::middleware('auth:sanctum')->prefix('admin/estats')->group(function () {
//     // Obtener una comanda específica
//     Route::get('/{id}', [OrderComercioController::class, 'show']);

//     // Crear un nueva comanda
//     Route::post('/', [OrderComercioController::class, 'store']);

//     // Actualizar una comanda
//     Route::post('/{id}', [OrderComercioController::class, 'update']);
// });

// ==== CATEGORIAS ===================
Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index']);

    Route::get('/{categoriaId}/comercios', [CategoriaController::class, 'ComerciosOfCategorias']);
});

// ==== SUBCATEGORIAS ===============
Route::prefix('subcategorias')->group(function () {
    Route::get('/{categoria_id}', [SubcategoriaController::class, 'show']);
});

// ==== PRODUCTO ====================
Route::prefix('producto')->group(function () {
    // Obtener todos los productos
    Route::get('/', [ProductoController::class, 'index']);

    // Obtener 8 productos aleatorios
    Route::get('/random', [ProductoController::class, 'randomProducts']);

    // Obtener todos los productos de un comercio específico
    Route::get('/comercio/{comercioID}', [ProductoController::class, 'getByComercio']);

    Route::get('/{id}', [ProductoController::class, 'show']);

    Route::get('/search/{search}', [ProductoController::class, 'search']);

    Route::get('/categoria/{categoriaID}', [CategoriaController::class, 'getProductosPorCategoria']);

    Route::post('crear_excel', [ProductoController::class, 'createExcel']);

    Route::get('/{id}/ratings', [RatingController::class, 'getProductoRatings']);
});

Route::prefix('cercanos')->group(function () {
    Route::get('/productos', [ProductoController::class, 'prueba']);
});


Route::middleware('auth:sanctum')->prefix('producto')->group(function () {
    // Crear un nuevo producto
    Route::post('/', [ProductoController::class, 'store']);

    // Actualizar un producto específico
    Route::post('{id}', [ProductoController::class, 'update']);

    // Actualizar visibilidad de un producto específico
    Route::post('/visible/{id}', [ProductoController::class,'updateVisibility']);

    // Eliminar un producto específico
    Route::delete('{id}', [ProductoController::class, 'destroy']);

});

// ==== CLIENTES ====================
Route::middleware('auth:sanctum')->prefix( 'clientes')->group(function () {
    Route::get('{id}', [ClienteController::class, 'obtenerDatosCliente']);

    Route::get('{id}/compras', [OrderController::class, 'comprasCliente']);

    Route::get('compras/{id}', [OrderController::class, 'detalleCompra']);
});

Route::prefix('poblaciones')->group(function () {
    // Ver provincias
    Route::get('/provincias', [ProvinciasController::class, 'index']);

    // Ver ciudades por provincia seleccionada
    Route::get('/ciudades/{id}', [CiudadesController::class, 'index']);
});

Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');




// Route::post('/create-checkout-session', [PaymentController::class, 'createCheckoutSession']);
// Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
// Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
// Route::post('/process-payment', [PaymentController::class, 'processPayment']);

Route::middleware('auth:sanctum')->prefix( 'stripe')->group(function () {
    Route::post('create-setup-intent', [PaymentController::class, 'createSetupIntent'])->name('stripe.createSetupIntent');
    Route::post('add-payment-method', [PaymentController::class, 'addPaymentMethod'])->name('stripe.addPaymentMethod');
    Route::post('retrieve-payment-method', [PaymentController::class, 'retrievePaymentMethod'])->name('stripe.retrievePaymentMethod');
    Route::post('set-default-payment-method', [PaymentController::class, 'setDefaultPaymentMethod'])->name('stripe.setDefaultPaymentMethod');
    Route::post('create-express-account', [PaymentController::class, 'createExpressAccount'])->name('stripe.createExpressAccount');
    Route::post('generate-onboarding-link', [PaymentController::class, 'generateOnboardingLink'])->name('stripe.generateOnboardingLink');
    Route::post('purchase', [PaymentController::class, 'purchase'])->name('stripe.purchase');
    Route::post('delete-payment-method', [PaymentController::class, 'delete'])->name('stripe.delete');
});

Route::middleware('auth:sanctum')->prefix('stats')->group(function () {
    Route::get('orders', [StatsController::class, 'sales']);
    Route::get('top-products-clients', [StatsController::class, 'getTopProductsClients']);
    Route::get('get-comercio-rating', [StatsController::class, 'getRating']);
    Route::get('get-ratings', [StatsController::class, 'getRatingData']);
    Route::get('/reviewsComercio', [RatingController::class, 'getComercioReviews']);
    Route::get('/reviewsProducto', [RatingController::class, 'getProductoReviews']);
});