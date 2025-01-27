<?php
    namespace App\Http\Controllers;

    use App\Models\Order;
    use Illuminate\Http\Request;

    class OrderController extends Controller {
        public function comprasCliente($clienteId) {
            try {
                $compras = Order::with(['productosCompra.producto', 'tipoEnvio'])
                    ->where('cliente_id', $clienteId)
                    ->orderBy('fecha', 'desc')
                    ->get();

                dd($compras->toArray());

                // Verificar si hay compras
                if ($compras->isEmpty()) {
                    return response()->json(['message' => 'No se encontraron compras para este cliente.'], 404);
                }

                // Modificar los datos de respuesta para incluir el id y nombre del tipo de envío
                $compras->transform(function ($order) {
                    $order->tipo_envio_info = [
                        'id' => $order->tipoEnvio->id,
                        'nombre' => $order->tipoEnvio->nombre
                    ];

                    return $order;
                });

                return response()->json($compras, 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Ocurrió un error al obtener las compras: ' . $e->getMessage()], 500);
            }
        }
    }