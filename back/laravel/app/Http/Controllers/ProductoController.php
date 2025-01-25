<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
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
                "precio" => $producto->precio,
                "stock" => $producto->stock
            ];
        });
        if ($productos->isEmpty()) {
            return response()->json(['message' => 'No hay productos'], 200);
        }

        return response()->json(['data' => $productos], 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'comercio_id' => 'required|exists:comercios,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

        $imagenPath = $request->file('imagen')->store('productos', 'public');

        $producto = Producto::create([
            'subcategoria_id' => $validated['subcategoria_id'],
            'comercio_id' => $validated['comercio_id'],
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'precio' => $validated['precio'],
            'stock' => $validated['stock'],
            'imagen' => $imagenPath,
        ]);

        return response()->json([
            'message' => 'Producto creado con éxito.',
            'producto' => $producto
        ], 201);
    }
    





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
            "precio" => $producto->precio,
            "stock" => $producto->stock
        ], 200);
    }

    public function edit(Producto $producto)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'comercio_id' => 'required|exists:comercios,id',
            "stock" => "nullable | numeric | min:0",
        ]);


        try {
            $producto = Producto::findOrFail($id);

            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'subcategoria_id' => $request->subcategoria_id,
                'comercio_id' => $request->comercio_id,
                "stock" => $request->stock,
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
