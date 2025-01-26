<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller {
    public function RegistrarCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:cliente,email',
            'phone' => 'integer | digits:9',
            'password' => 'required|string|min:8|confirmed',
            'streed_address' => 'string|max:255',
            'ciudad' => 'string|max:100',
            'provincia' => 'string|max:100',
            'codigo_postal' => 'integer',
            'numero_planta' => 'integer',
            'numero_puerta' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $cliente = Cliente::create([
            'nombre' => $request->name,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'street_address' => $request->street_address,
            'ciudad' => $request->ciudad,
            'provincia' => $request->provincia,
            'codigo_postal' => $request->codigo_postal,
            'numero_planta' => $request->numero_planta,
            'numero_puerta' => $request->numero_puerta,
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $cliente = Cliente::where('email', $request->email)->first();

        if (!$cliente) {
            return response()->json([
                'error' => 'Cliente no encontrado.'
            ], 404);
        }

        if (!Hash::check($request->password, $cliente->password)) {
            return response()->json([
                'error' => 'Credenciales incorrectas.'
            ], 401);
        }

        // if ($cliente->email_verified_at === null) {
        //     return response()->json([
        //         'error' => 'Por favor, verifica tu correo electrónico antes de iniciar sesión.'
        //     ], 400);
        // }

        $token = $cliente->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'user' => $cliente,
            'token' => $token,
        ], 200);
    }

    public function obtenerDatosCliente(Request $request, $id) {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'error' => 'Cliente no encontrado.'
            ], 404);
        }

        return response()->json([
            'message' => 'Datos del cliente obtenidos correctamente.',
            'cliente' => [
                'nombre' => $cliente->name,
                'apellidos' => $cliente->apellidos,
                'email' => $cliente->email,
                'phone' => $cliente->phone,
                'street_address' => $cliente->street_address,
                'ciudad' => $cliente->ciudad,
                'provincia' => $cliente->provincia,
                'codigo_postal' => $cliente->codigo_postal,
                'numero_planta' => $cliente->numero_planta,
                'numero_puerta' => $cliente->numero_puerta,
            ]
        ], 200);
    }
}