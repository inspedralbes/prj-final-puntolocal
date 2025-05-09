<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderComercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
}