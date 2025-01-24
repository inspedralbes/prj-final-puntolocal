<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // dd($request->all());
        
        $validated = $request->validate([
            "subcategoria_id" => "required | integer",
            "comercio_id" => "required | integer",
            "nombre" => "required | string | max:60",
            "descripcion" => "string | max:500",
            "precio" => "required | numeric | min:0 | max: 99999.99",
            'imagenes' => 'array|max:4',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // dd($validated);

        try {
            $imagenesRutas = [];
            if ($request->has('imagenes')) {
                foreach ($request->file('imagenes') as $imagen) {
                    $imagenesRutas[] = $imagen->store('productos', 'public');
                }
                $validated['imagenes'] = json_encode($imagenesRutas);
            }

            $producto = Producto::create($validated);
            if(!$producto){
                return response()->json(['error' => 'Producto no creado'], 404);
            }
            return response()->json(['message' => 'Producto creado exitosamente', 'data' => $producto], 201);
        } catch (error) {
            return response()->json(['error'=> ''], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $validated = $request->validate(["id_producto" => "required | integer"]);
        $producto = Producto::with('categoriaConcreta', 'comercio')
            ->find($validated['id_producto']);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
        return response()->json($producto, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
