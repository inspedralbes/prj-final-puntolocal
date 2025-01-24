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
        $productos = Producto::with('subcategoria', 'comercio')->get()->map(function ($producto) {
            return [
                "nombre" => $producto->nombre,
                "descripcion" => $producto->descripcion,
                "subcategoria_id" => $producto->subcategoria_id,
                'subcategoria' => $producto->subcategoria ? $producto->subcategoria->name : null,
                "comercio_id" => $producto->comercio_id,
                "comercio" => $producto->comercio->nombre,
                "precio" => $producto->precio
            ];
        });
        if ($productos->isEmpty()) {
            return response()->json(['message' => 'No hay productos'], 200);  // Se puede devolver un 200 en vez de 404
        }

        return response()->json(['data' => $productos], 200);
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
            if (!$producto) {
                return response()->json(['error' => 'Producto no creado'], 404);
            }
            return response()->json(['message' => 'Producto creado exitosamente', 'data' => $producto], 201);
        } catch (error) {
            return response()->json(['error' => ''], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::with('subcategoria', 'comercio')->where('id', $id)->first();

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            "nombre" => $producto->nombre,
            "descripcion" => $producto->descripcion,
            "subcategoria_id" => $producto->subcategoria_id,
            "subcategoria" => $producto->subcategoria ? $producto->subcategoria->name : null,
            "comercio_id" => $producto->comercio_id,
            "comercio" => $producto->comercio->nombre,
            "precio" => $producto->precio
        ], 200);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'comercio_id' => 'required|exists:comercios,id',
        ]);
        

        try {
            $producto = Producto::findOrFail($id);
    
            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'subcategoria_id' => $request->subcategoria_id,
                'comercio_id' => $request->comercio_id,
            ]);
    
            return response()->json([
                'message' => 'Producto actualizado con éxito',
                'data' => $producto
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Producto no actualizado',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        try {
            $producto->delete();
            return response()->json(['message' => 'Producto eliminado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Producto no eliminado',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
