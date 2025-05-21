<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Order;
use App\Models\OrderComercio;
use App\Models\ProductoOrder;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Log;

class StatsController extends Controller
{
    public function sales(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period' => 'sometimes|in:week,month,year'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Periodo no válido'], 400);
        }

        $cliente = Auth::user();
        $comerciosIds = $cliente->comercios()->pluck('id');

        if ($comerciosIds->isEmpty()) {
            return response()->json(['error' => 'Cliente no tiene comercios asociados'], 400);
        }

        $period = $request->input('period', 'week');

        try {
            $data = match ($period) {
                'week' => $this->getWeeklyStats($comerciosIds),
                'month' => $this->getMonthlyStats($comerciosIds),
                'year' => $this->getYearlyStats($comerciosIds),
            };

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getWeeklyStats($comerciosIds)
    {
        $endDate = Carbon::today()->endOfDay();
        $startDate = Carbon::today()->subWeek()->startOfDay();

        $sales = OrderComercio::whereIn('comercio_id', $comerciosIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, CAST(SUM(subtotal) AS DECIMAL(10,2)) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->formatResponse($sales);
    }

    private function getMonthlyStats($comerciosIds)
    {
        $sales = OrderComercio::whereIn('comercio_id', $comerciosIds)
            ->whereMonth('created_at', Carbon::now()->month)
            ->selectRaw('DATE(created_at) as date, CAST(SUM(subtotal) AS DECIMAL(10,2)) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->formatResponse($sales);
    }

    private function getYearlyStats($comerciosIds)
    {
        $sales = OrderComercio::whereIn('comercio_id', $comerciosIds)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('MONTH(created_at) as month, CAST(SUM(subtotal) AS DECIMAL(10,2)) as total')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return [
            'labels' => $sales->pluck('month')->map(fn($m) => $this->getMonthName($m)),
            'data' => $sales->pluck('total')->map(fn($v) => (float) $v),
            'average' => (float) $sales->avg('total')
        ];
    }

    private function formatResponse($sales)
    {
        return [
            'labels' => $sales->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d/m/Y')),
            'data' => $sales->pluck('total')->map(fn($v) => (float) $v),
            'average' => (float) $sales->avg('total')
        ];
    }

    private function getMonthName($monthNumber)
    {
        return Carbon::create()->month($monthNumber)->locale('ca_ES')->monthName;
    }

    private function getTopProducts()
    {
        $products = ProductoOrder::with('producto:id,nombre,imagen', 'orderComercio:id,created_at')
            ->whereHas('orderComercio', function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            })
            ->get();

        $topProducts = $products->groupBy('producto.id')
            ->map(function ($group) {
                $total = $group->sum(fn($grupo) => $grupo->precio);
                return [
                    'producto_id' => $group->first()->producto_id,
                    'nombre' => $group->first()->producto->nombre,
                    'total' => $total,
                    'imagen' => $group->first()->producto->imagen,
                    'fecha' => $group->first()->orderComercio->created_at
                ];
            })
            ->sortByDesc(fn($item) => $item['total'])
            ->take(4)
            ->values()->all();

        return $topProducts;
    }

    private function getTopClients($orders)
    {
        $topClients = $orders->groupBy('order.cliente_id')
            ->map(function ($group) {
                $nombreCliente = $group->first()->order->cliente->name . ' ' . substr($group->first()->order->cliente->apellidos, 0, 1) . '.';
                return [
                    'cliente_id' => $group->first()->order->cliente_id,
                    'nombre' => $nombreCliente,
                    'subtotal' => $group->sum('subtotal'),
                ];
            })
            ->sortByDesc(fn($item) => $item['subtotal'])
            ->take(4)
            ->values()->all();

        return $topClients;
    }

    public function getTopProductsClients()
    {
        try {
            $user = Auth::user();

            if (!$user)
                return response()->json(['error' => 'Usuario no encontrado'], 404);

            $comercio = Comercio::where('idUser', $user->id)->first();

            if (!$comercio)
                return response()->json(['error' => 'Comercio no encontrado'], 404);

            $orders = OrderComercio::with('order:id,cliente_id', 'order.cliente:id,name,apellidos')
                ->where('comercio_id', $comercio->id)
                ->whereMonth('created_at', Carbon::now()->month)
                ->get();

            if (!$orders) {
                return response()->json(['message' => 'No tiene ninguna orden'], 404);
            }

            $topClients = $this->getTopClients($orders);

            $topProducts = $this->getTopProducts();

            $uniqueClients = $orders->pluck('order.cliente_id')->unique()->count();


            return response()->json(['topProducts' => $topProducts, 'topClients' => $topClients, 'uniqueClients' => $uniqueClients], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }

    public function getRating()
    {
        try {
            $user = Auth::user();

            if (!$user)
                return response()->json(['error' => 'Usuario no encontrado'], 404);

            $comercio = Comercio::where('idUser', $user->id)->first();

            if (!$comercio)
                return response()->json(['error' => 'Comercio no encontrado'], 404);

            return response()->json(['rating' => $comercio->puntaje_medio], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }

    public function getRatingData()
    {
        try {
            $user = Auth::user();

            if (!$user)
                return response()->json(['error' => 'Usuario no encontrado'], 404);

            $comercio = Comercio::where('idUser', $user->id)->first();

            if (!$comercio)
                return response()->json(['error' => 'Comercio no encontrado'], 404);

            $ratings = Rating::where('rateable_type', 'App\Models\Comercio')
                ->where('rateable_id', $comercio->id)
                ->get();

            $totalRatings = $ratings->count();

            $ratings = $ratings->groupBy('rating')->map(function($ratingGroup){
                return [
                    'count' => $ratingGroup->count(),
                ];
            })->toArray();

            return response()->json(['rating' => $ratings, 'totalRatings' => $totalRatings], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los detalles de la compra: ' . $e->getMessage()], 500);
        }
    }
}