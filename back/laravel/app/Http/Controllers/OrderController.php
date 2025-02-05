<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {
    public function index() {
        try {
            $user = Auth::user();
            $orders = Order::with('tipoEnvio', 'estatCompra', )->orderBy("created_at","desc")->where('cliente_id', $user->id)->get();

            if(empty($orders)){
                return response()->json(['message' => 'No tiene órdenes'], 404);
            }

            return response()->json($orders, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id) {
        try {
            $order = Order::with([
                'tipoEnvio', 
                'estatCompra', 
                'cliente', 
                'orderComercios.comercio',
                'orderComercios.productosCompra.producto'
                ])
            ->where('id', $id)
            ->first();
    
            if (!$order) {
                return response()->json(['message' => 'Compra no encontrada.'], 404);
            }
    
            foreach ($order->orderComercios as $orderComercio) {
                if ($orderComercio->comercio) {
                    $orderComercio->comercio_nombre = $orderComercio->comercio->nombre;
                }
    
                foreach ($orderComercio->productosCompra as $productoCompra) {
                    if ($productoCompra->producto) {
                        $productoCompra->producto_nombre = $productoCompra->producto->nombre;
                    }
                }
            }
    
            return response()->json($order, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }
    

    public function showOrdersComercios($id)
    {
        try {
            $user = Auth::user();
            $order = Order::with('tipoEnvio', 'estatCompra', 'orderComercios.estatCompra', 'orderComercios.productosCompra.producto:id,nombre,precio,imagen', 'orderComercios.comercio:id,nombre')->where('id', $id)->where('cliente_id', $user->id)->first();

            if (!$order) {
                return response()->json(['message' => 'Comanda no encontrada.'], 404);
            }

            return response()->json($order, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }

    // public function showSuborder($id)
    // {
    //     try {
    //         $user = Auth::user();
    //         $order = Order::with('tipoEnvio', 'estatCompra', 'orderComercios', 'orderComercios.productosCompra', 'orderComercios.productosCompra.producto')->where('id', $id)->where('cliente_id', $user->id)->first();

    //         if (!$order) {
    //             return response()->json(['message' => 'Comanda no encontrada.'], 404);
    //         }

    //         return response()->json($order, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
    //     }
    // }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
    public function comprasCliente($clienteId)
    {
        try {
            $compras = Order::with(['tipoEnvio'])->where('cliente_id', $clienteId)->orderBy('fecha', 'desc')->get();
            $compras->load('productosCompra.producto');

            if ($compras->isEmpty()) {
                return response()->json(['message' => 'No se encontraron compras para este cliente.'], 404);
            }

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

    public function detalleCompra($id)
    {
        try {
            $compra = Order::with(['estatCompra', 'tipoEnvio', 'productosCompra.producto'])
                ->where('id', $id)
                ->first();

            if (!$compra) {
                return response()->json(['message' => 'Compra no encontrada.'], 404);
            }

            $compra->tipo_envio_info = [
                'id' => $compra->tipoEnvio->id,
                'nombre' => $compra->tipoEnvio->nombre
            ];

            return response()->json($compra, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }


}
