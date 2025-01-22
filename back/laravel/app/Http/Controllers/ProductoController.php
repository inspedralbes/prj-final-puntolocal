<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validación de los datos de entrada
            $request->validate([
                'id_categoria_concreta' => 'required|exists:categorias_concretas,id',
                'id_comercio' => 'required|exists:comercios,id',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric|min:0',
                'imagenes' => 'nullable|array', // Aceptar un array de imágenes
                'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validación de cada imagen
            ]);

            // Crear el nuevo producto
            $producto = new Producto();
            $producto->id_categoria_concreta = $request->id_categoria_concreta;
            $producto->id_comercio = $request->id_comercio;
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;

            // Procesar las imágenes si están presentes
            if ($request->has('imagenes')) {
                $imagenes = [];

                // Iterar sobre las imágenes y guardarlas en 'public/imgs'
                foreach ($request->imagenes as $imagen) {
                    // Guardar la imagen en el directorio 'public/imgs' y obtener el nombre del archivo
                    $imagenes[] = $imagen->store('imgs', 'public');
                }

                // Guardar las imágenes como un JSON en el campo 'imagenes'
                $producto->imagenes = json_encode($imagenes); // Convertir el array a JSON
            }

            // Guardar el producto en la base de datos
            $producto->save();

            // Devolver respuesta exitosa
            return response()->json([
                'message' => 'Producto creado exitosamente.',
                'producto' => $producto,
            ], 201);

        } catch (\Exception $e) {
            // En caso de error, se captura la excepción y se registra
            Log::error('Error al crear el producto: ' . $e->getMessage());

            // Devolver respuesta con error
            return response()->json([
                'message' => 'Hubo un problema al crear el producto.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
