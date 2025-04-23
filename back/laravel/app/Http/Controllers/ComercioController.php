<?php
namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Producto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $request->file('imagen')->store('localComercios', 'public');
            $imagePath = str_replace('public/', '', $imagePath);
        }

        $comercio = Comercio::create([
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
            'imagen' => $imagePath,
        ]);

        Mail::send('emails.nuevo_comercio', ['comercio' => $comercio], function ($message) {
            $message->to(['a23arnbarsor@inspedralbes.cat', 'a23agunovnov@inspedralbes.cat'])
                ->subject('Nuevo Comercio Registrado');
        });

        return response()->json([
            'message' => 'Comercio creado exitosamente.',
            'comercio' => $comercio
        ], 201);
    }

    public function getComercios()
    {
        $comercios = Comercio::all();
        return response()->json(['comercios' => $comercios], 200);
    }


    public function getComerciosCercanos($latitud, $longitud)
    {
        $radio = 20;

        $comercios = Comercio::select(
            'id',
            'nombre',
            'logo_path as imagen',
            'latitude',
            'longitude',
            'calle_num',
            'ciudad',
            'provincia',
            'codigo_postal',
            'categoria_id',
            DB::raw("(6371 * acos(cos(radians($latitud)) 
                     * cos(radians(latitude)) 
                     * cos(radians(longitude) - radians($longitud)) 
                     + sin(radians($latitud)) 
                     * sin(radians(latitude)))) AS distancia")
        )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->having('distancia', '<=', $radio)
            ->orderBy('distancia', 'asc')
            ->get();

        if ($comercios->isEmpty()) {
            return response()->json(['message' => 'No hay comercios cerca de ti.'], 200);
        }

        return response()->json(['comercios' => $comercios], 200);
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
        $comercios = Comercio::select('id', 'nombre', 'latitude', 'longitude', 'puntaje_medio', 'horario', 'phone', 'email', 'calle_num', 'categoria_id', 'imagen')
            ->whereNotNull('ubicacion_verified_at')
            ->get();

        return response()->json(['comercios' => $comercios], 200);
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
        return response()->json(['usuario_id' => $comercio->idUser], 200);
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
                'logo_path' => $comercio->logo_path,
                'imagen_local_path' => $comercio->imagen_local_path,
                'horario' => $comercio->horario,
            ];
        });


        return response()->json(['data' => $comerciosMapeados], 200);
    }

    public function updateComercio(Request $request, $id)
    {
        $comercio = Comercio::find($id);
        if ($comercio == null) {
            return response()->json([
                'error' => 'Comerç no trobat'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'calle_num' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'codigo_postal' => 'required|integer',
            'num_planta' => 'required|integer',
            'num_puerta' => 'required|integer',
            'descripcion' => 'required|string|max:500',
            'categoria_id' => 'required|integer',
            'gestion_stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Camp invàlid',
            ], 422);
        }

        $comercio->update($request->all());

        return response()->json([
            'message' => 'Comerç actualitzat exitosament.',
            'comercio' => $comercio
        ], 200);
    }

    public function updateComercioImagenes(Request $request, $id)
    {
        try {
            $comercio = Comercio::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
                'imagen_local' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Error de validació',
                    'errors' => $validator->errors()
                ], 422);
            }

            $updateData = [];

            // Procesar logo
            if ($request->hasFile('logo')) {
                // Eliminar logo anterior si existe
                if ($comercio->logo_path) {
                    Storage::disk('public')->delete($comercio->logo_path);
                }

                $logoPath = $request->file('logo')->store('comercios/logos', 'public');
                $updateData['logo_path'] = $logoPath;
            }

            // Procesar imagen del local
            if ($request->hasFile('imagen_local')) {
                // Eliminar imagen anterior si existe
                if ($comercio->imagen_local_path) {
                    Storage::disk('public')->delete($comercio->imagen_local_path);
                }

                $imagenLocalPath = $request->file('imagen_local')->store('comercios/locales', 'public');
                $updateData['imagen_local_path'] = $imagenLocalPath;
            }

            // Actualizar solo si hay cambios
            if (!empty($updateData)) {
                $comercio->update($updateData);
            }

            return response()->json([
                'message' => 'Imatges actualitzades correctament',
                'comercio' => $comercio->fresh()
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comerç no trobat'], 404);
        } catch (\Exception $e) {
            \Log::error("Error en updateComercioImagenes: " . $e->getMessage());
            return response()->json([
                'error' => 'Error del servidor',
                'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function deleteComercioImagen(Request $request, $id)
    {
        try {
            $comercio = Comercio::findOrFail($id);

            $request->validate([
                'tipo_imagen' => 'required|in:logo,imagen_local'
            ]);

            $tipoImagen = $request->input('tipo_imagen');
            $campoPath = $tipoImagen . '_path';

            if (empty($comercio->$campoPath)) {
                return response()->json([
                    'error' => "No existeix la imatge de tipus $tipoImagen per a aquest comerç"
                ], 404);
            }

            // Eliminar del almacenamiento
            Storage::disk('public')->delete($comercio->$campoPath);

            // Actualizar campo a null
            $comercio->$campoPath = null;
            $comercio->save();

            return response()->json([
                'message' => "Imatge de $tipoImagen eliminada correctament",
                'comercio' => $comercio->fresh()
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comerç no trobat'], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dades invàlides',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error en deleteComercioImagen: " . $e->getMessage());
            return response()->json([
                'error' => 'Error del servidor',
                'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
}