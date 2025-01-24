<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Comercio;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ComercioController extends Controller
{
    //
    public function RegistrarComercio(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'street_address' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'codigo_postal' => 'required|integer',
            'numero_planta' => 'required|integer',
            'numero_puerta' => 'required|integer',
            'descripcion' => 'required|string|max:500',
            'categoria' => 'required|integer',
            'idUser' => 'required|integer',
            'gestion_stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $cliente = Comercio::create([
            'nombre' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'calle_num' => $request->street_address,
            'ciudad' => $request->ciudad,
            'provincia' => $request->provincia,
            'cp' => $request->codigo_postal,
            'num_planta' => $request->numero_planta,
            'num_puerta' => $request->numero_puerta,
            'categoria_general_id' => $request->categoria,
            'idUser' => $request->idUser,
            'descripcion' => $request->descripcion,
            'gestion_stock' => $request->gestion_stock,
            'puntaje_medio' => 0,
        ]);

        $verificationUrl = route('verification.verify', ['id' => $cliente->id, 'hash' => sha1($cliente->email)]);

        // Mail::send('emails.verify', ['verificationUrl' => $verificationUrl], function ($message) use ($cliente) {
        //     $message->to($cliente->email)
        //             ->subject('Verificación de email | ·LOCAL');
        // });

        return response()->json([
            'message' => 'Cliente creado exitosamente. Por favor, verifica tu correo electrónico.',
            'cliente' => $cliente
        ], 201);
    }

    public function getComercios() {
        $comercios = Comercio::all();
        return response()->json($comercios, 200);
    }

    public function getComercio($id) {
        $comercio = Comercio::find($id);
        if ($comercio == null) {
            return response()->json([
                'error' => 'Comercio no encontrado'
            ], 404);
        }
        return response()->json($comercio, 200);
    }
}
