<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Producto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ComercioController extends Controller
{
    public function RegistrarComercio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'idUser' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'street_address' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'codigo_postal' => 'required|integer',
            'num_planta' => 'required|integer',
            'num_puerta' => 'required|integer',
            'descripcion' => 'required|string|max:500',
            'categoria' => 'required|integer',
            'gestion_stock' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validar imagen
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
    
        // 📌 Manejo de la imagen con Laravel Storage (igual que en productos)
        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension(); // Nombre único
            $imagePath = $request->file('imagen')->store('localComercios', 'public'); // Almacenar en localComercios
            $imagePath = str_replace('public/', '', $imagePath); // Guardar solo la ruta relativa
        }
    
        // 📌 Crear el comercio en la base de datos
        $cliente = Comercio::create([
            'nombre' => $request->nombre,
            'idUser' => $request->idUser,
            'email' => $request->email,
            'phone' => $request->phone,
            'calle_num' => $request->street_address,
            'ciudad' => $request->ciudad,
            'provincia' => $request->provincia,
            'codigo_postal' => $request->codigo_postal,
            'num_planta' => $request->num_planta,
            'num_puerta' => $request->num_puerta,
            'categoria_id' => $request->categoria,
            'descripcion' => $request->descripcion,
            'gestion_stock' => $request->gestion_stock,
            'puntaje_medio' => 0,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'imagen' => $imagePath, // Guardar la ruta de la imagen
        ]);
    
        // 📌 Enviar correo (Opcional)
        Mail::send('emails.nuevo_comercio', ['comercio' => $cliente], function ($message) {
            $message->to(['a23arnbarsor@inspedralbes.cat', 'a23agunovnov@inspedralbes.cat'])
                ->subject('Nuevo Comercio Registrado');
        });
    
        return response()->json([
            'message' => 'Cliente creado exitosamente.',
            'cliente' => $cliente
        ], 201);
    }
    


    public function getComercios()
    {
        $comercios = Comercio::all();
        return response()->json($comercios, 200);
    }

    public function getComercio($id)
    {
        $comercio = Comercio::find($id);

        if ($comercio == null) {
            return response()->json([
                'error' => 'Comercio no encontrado'
            ], 404);
        }

        $productos = Producto::with('subcategoria')
            ->where('comercio_id', $id)
            ->get();

        $productosData = $productos->map(function ($producto) {
            return [
                'producto_id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'imagen' => $producto->imagen,
                'altitud' => $producto->altitud,
                'latitud' => $producto->latitud,
                'subcategoria' => $producto->subcategoria ? [
                    'id' => $producto->subcategoria->id,
                    'name' => $producto->subcategoria->name,
                ] : null,
            ];
        });

        return response()->json([
            'comercio' => $comercio,
            'productos' => $productosData,
        ], 200);
    }

    public function getLocations()
    {
        $comercios = Comercio::select('id', 'nombre', 'latitude', 'longitude', 'puntaje_medio', 'horario', 'imagen')
            ->whereNotNull('ubicacion_verified_at')
            ->get();

        return response()->json($comercios);
    }

    public function checkUserHasComercio($userId)
    {
        $comercio = Comercio::where('idUser', $userId)->first();
        if ($comercio) {
            return response()->json([
                'success' => true,
                'message' => 'El usuario tiene un comercio.',
                'comercio' => $comercio
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'El usuario no tiene un comercio.'
            ], 404);
        }
    }

    public function getUserID($id)
    {
        $comercio = Comercio::find($id);
        if (!$comercio) {
            return response()->json([
                'message' => 'No existeix cap comerç amb aquest id.'
            ], 404);
        }
        return response()->json(['usuario_id' => $comercio->id], 200);
    }

    public function search($search)
    {
        $validator = Validator::make(['search' => $search], [
            'searchTerm' => 'required|integer',
        ]);

        if (empty($search)) {
            return response()->json(['message' => 'El término de búsqueda no puede estar vacío'], 400);
        }

        $comercios = Comercio::where('nombre', 'like', "%$search%")->get();

        if ($comercios->isEmpty()) {
            return response()->json(['message' => 'No hay comercios que coincidan con tu búsqueda'], 200);
        }

        $comerciosMapeados = $comercios->map(function ($comercio) {
            return [
                'id' => $comercio->id,
                'nombre' => $comercio->nombre,
                'categoria_id' => $comercio->categoria_id,
                'puntaje_medio' => $comercio->puntaje_medio,
                'imagenes' => $comercio->imagenes,
                'horario' => $comercio->horario,
            ];
        });


        return response()->json(['data' => $comerciosMapeados], 200);
    }
}
