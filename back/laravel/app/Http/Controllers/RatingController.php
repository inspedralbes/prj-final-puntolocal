<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Comercio;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RatingController extends Controller
{
    // Crear nueva valoración
    public function store(Request $request)
    {
        //var_dump($request->all());

        $validated = $request->validate([
            'rateable_type' => ['required', 'string', Rule::in(['comercio', 'producto'])],
            'rateable_id' => 'required|integer',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500'
        ]);

        // Verificar existencia del recurso
        $modelClass = $validated['rateable_type'] === 'comercio'
            ? Comercio::class
            : Producto::class;

        if (!$modelClass::where('id', $validated['rateable_id'])->exists()) {
            return response()->json(['error' => 'Recurso no encontrado'], 404);
        }

        // Verificar si ya existe una valoración
        $existingRating = Rating::where('cliente_id', Auth::id())
            ->where('rateable_type', $modelClass)
            ->where('rateable_id', $validated['rateable_id'])
            ->first();

        if ($existingRating) {
            return response()->json([
                'error' => 'Ya has valorado este ' . $validated['rateable_type'],
                'existing_rating' => $existingRating
            ], 422);
        }

        // Crear la valoración
        $rating = Rating::create([
            'cliente_id' => Auth::id(),
            'rateable_type' => $modelClass,
            'rateable_id' => $validated['rateable_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        // Actualizar puntuación del comercio
        if ($validated['rateable_type'] === 'comercio') {
            $this->updateComercioPuntaje($validated['rateable_id']);
        }

        return response()->json($rating, 201);
    }

    private function updateComercioPuntaje($comercioId)
    {
        $promedio = Rating::where('rateable_type', Comercio::class)
            ->where('rateable_id', $comercioId)
            ->avg('rating');

        Comercio::where('id', $comercioId)->update([
            'puntaje_medio' => round($promedio, 2) 
        ]);
    }

    // Obtener valoraciones de un comercio
    public function getComercioRatings($comercioId)
    {

        $ratings = Rating::where('rateable_type', Comercio::class)
            ->where('rateable_id', $comercioId)
            ->join('clientes', 'ratings.cliente_id', '=', 'clientes.id')
            ->select('ratings.*', 'clientes.name', 'clientes.apellidos')
            ->where('rateable_id', $comercioId)
            ->paginate(10);

        return response()->json([
            'average' => $this->calculateAverage(Comercio::class, $comercioId),
            'ratings' => $ratings
        ]);
    }

    // Obtener valoraciones de un producto
    public function getProductoRatings(Request $request, $productoId)
    {
        $perPage = $request->input('per_page', 5);

        $query = Rating::with(['cliente:id,name,apellidos'])
            ->where('rateable_type', Producto::class)
            ->where('rateable_id', $productoId)
            ->latest();

        // Determinar si es paginación o todos
        $ratings = ($perPage === 'all')
            ? $query->get()
            : $query->paginate($perPage);

        return response()->json([
            'average' => $this->calculateAverage(Producto::class, $productoId),
            'ratings' => $ratings
        ]);
    }

    // Calcular promedio
    private function calculateAverage($modelClass, $id)
    {
        $avg = Rating::where('rateable_type', $modelClass)
            ->where('rateable_id', $id)
            ->avg('rating');

        // Actualizar puntaje si es comercio
        if ($modelClass === Comercio::class) {
            Comercio::where('id', $id)->update([
                'puntaje_medio' => round($avg, 2)
            ]);
        }

        return $avg;
    }
}