<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\OrderComercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderComercioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $comercio = Comercio::where('idUser', $user->id)->first();

            $orders = OrderComercio::with('estatCompra','order:id,tipo,cliente_id','order.tipoEnvio','order.cliente')->where('comercio_id', $comercio->id)->get();

            if (!$orders) {
                return response()->json(['message' => 'No tiene ninguna orden'], 404);
            }

            return response()->json($orders, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            $comercio = Comercio::where('idUser', $user->id)->first();

            $order = OrderComercio::with('estatCompra','order:id,tipo,cliente_id','order.tipoEnvio', 'order.cliente', 'productosCompra.producto')->where('comercio_id', $comercio->id)->where('order_id', $id)->first();

            if (!$order) {
                return response()->json(['message' => 'No tienes ninguna orden con ID #'.$id.'.'], 404);
            }

            return response()->json($order, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderComercio $orderComercio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $comercio = Comercio::where('idUser', $user->id)->first();

            $validated = $request->validate([
                'estat' => 'required|integer|exists:estat_compras,id'
            ]);

            $order = OrderComercio::with('estatCompra','order:id,tipo','order.tipoEnvio')->where('comercio_id', $comercio->id)->where('id', $id)->first();

            if (!$order) {
                return response()->json(['message' => 'No tienes ninguna orden con ese ID.'], 404);
            }
            $order->estat = $validated['estat'];
            $order->save();
            $order->load('estatCompra');

            return response()->json($order, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderComercio $orderComercio)
    {
        //
    }
}
