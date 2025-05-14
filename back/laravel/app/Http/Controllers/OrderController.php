<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $orders = Order::with('tipoEnvio', 'tipoPago', 'estatCompra', )->orderBy("created_at", "desc")->where('cliente_id', $user->id)->get();

            if (empty($orders)) {
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
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'tipo_envio' => 'required|exists:tipo_envios,id',
                'tipo_pago' => 'required|exists:tipo_pagos,id',
                'total' => 'required|numeric',
                'payment_method_id' => 'nullable|string'
            ]);

            $total = intval($request->total * 100);
            $comision = intval($total * 0.05);
            $total -= $comision;

            if($request->tipo_pago === '2'){
                Stripe::setApiKey(config('cashier.secret'));
    
                $paymentIntent = PaymentIntent::create([
                    'amount' => $total,
                    'currency' => 'eur',
                    'payment_method' => $request->payment_method_id,
                    'customer' => $user->stripe_id,
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],
                ]);
            }

            $order = Order::create([
                'tipo_envio' => $validated['tipo_envio'],
                'tipo_pago' => $validated['tipo_pago'],
                'total' => $validated['total'],
                'cliente_id' => $user->id,
                'estat' => 1,
            ]);

            $orderCompleta = Order::where("id", $order->id)->with('cliente:id,name,apellidos', 'tipoEnvio', 'tipoPago', 'estatCompra')->first();

            return response()->json([
                'message' => 'Orden creada con éxito.',
                'order' => $order,
                'orderCompleta' => $orderCompleta
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al crear la orden: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $order = Order::with([
                'tipoEnvio',
                'tipoPago',
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
            $order = Order::with([
                'tipoEnvio',
                'tipoPago',
                'estatCompra',
                'orderComercios' => function ($query) use ($user) {
                    $query->with([
                        'estatCompra',
                        'comercio' => function ($q) use ($user) {
                            $q->select('id', 'nombre')
                                ->with([
                                    'ratings' => function ($qr) use ($user) {
                                        $qr->where('cliente_id', $user->id);
                                    }
                                ]);
                        },
                        'productosCompra.producto.ratings' => function ($q) use ($user) {
                            $q->where('cliente_id', $user->id);
                        },
                        'ratings' => function ($q) use ($user) {
                            $q->where('cliente_id', $user->id);
                        }
                    ]);
                }
            ])->where('id', $id)->where('cliente_id', $user->id)->first();

            if (!$order) {
                return response()->json(['message' => 'Comanda no encontrada.'], 404);
            }

            if ($order->orderComercios) {
                $order->orderComercios->each(function ($comercioOrder) {
                    $comercioOrder->can_rate = $comercioOrder->comercio->ratings->isEmpty() ?? true;
                    unset($comercioOrder->comercio->ratings);

                    if ($comercioOrder->productosCompra) {
                        $comercioOrder->productosCompra->each(function ($productoOrder) {
                            $productoOrder->producto->can_rate = optional($productoOrder->producto->ratings)->isEmpty() ?? true;
                            unset($productoOrder->producto->ratings);
                        });
                    }
                });
            }

            return response()->json($order, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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

    public function comprasCliente($clienteId)
    {
        try {
            $compras = Order::with(['tipoEnvio'])->where('cliente_id', $clienteId)->orderBy('created_at', 'desc')->get();
            // $compras->load('productosCompra.producto');

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
            $compra = Order::with(['estatCompra', 'tipoEnvio'])
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
