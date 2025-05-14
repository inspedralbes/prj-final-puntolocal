<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comercio;

class HorarioController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'horario' => 'required|array',
        'comercio_id' => 'required|exists:comercios,id'
    ]);

    $comercio = Comercio::find($validated['comercio_id']);
    
    // Validar formato de cada horario
    foreach($validated['horario'] as $dia => $rango) {
        if (!preg_match('/^\d{2}:\d{2} - \d{2}:\d{2}$/', $rango)) {
            return response()->json(['error' => "Formato inválido para $dia"], 422);
        }
    }
    
    $comercio->horario = $validated['horario'];
    $comercio->save();

    return response()->json(['horario' => $comercio->horario]);
}

public function update(Request $request, $comercioId)
{
    

    // 1) Validamos que venga un array 'horario' y que TODOS sus valores cumplan el formato
    $validated = $request->validate([
        'horario'      => 'required|array',
        'horario.*'    => ['required', 'regex:/^\d{2}:\d{2} - \d{2}:\d{2}$/'],
    ]);

    // 2) Recuperamos el modelo
    $comercio = Comercio::findOrFail($comercioId);

    // 3) Aseguramos que siempre trabajamos con un array (si lo guardas en JSON en BD)
    //    Si en tu modelo ya tienes: protected $casts = ['horario' => 'array'];
    //    podrías omitir este paso.
    $existing = $comercio->horario;
    if (is_string($existing)) {
        $existing = json_decode($existing, true) ?: [];
    }

    // 4) Fusionamos el nuevo horario sobre el existente
    //    (los días que mandes reemplazarán a los anteriores)
    $nuevoHorario = array_merge($existing, $validated['horario']);

    // 5) Guardamos y devolvemos respuesta
    $comercio->horario = $nuevoHorario;
    $comercio->save();

    return response()->json([
        'message' => 'Horario actualizado correctamente',
        'horario' => $comercio->horario,
    ]);
}
}