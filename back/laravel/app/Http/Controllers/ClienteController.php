<?php
    namespace App\Http\Controllers;

    use App\Models\Cliente;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

    class ClienteController extends Controller {
        
        public function getCliente($id) {
            $cliente = Cliente::find($id);
            if ($cliente) {
                return response()->json($cliente, 200);
            } else {
                return response()->json(['message' => 'Cliente no encontrado'], 404);
            }
        }

        public function updateCliente(Request $request, $id) {
            $cliente = Cliente::find($id);
            if ($cliente) {
                $validator = Validator::make($request->all(), [
                    'nombre' => 'required',
                    'apellido' => 'required',
                    'email' => 'required|email',
                    'telefono' => 'required',
                    'direccion' => 'required',
                    'password' => 'required'
                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => 'Datos incorrectos'], 400);
                }
                $cliente->nombre = $request->nombre;
                $cliente->apellido = $request->apellido;
                $cliente->email = $request->email;
                $cliente->telefono = $request->telefono;
                $cliente->direccion = $request->direccion;
                $cliente->password = Hash::make($request->password);
                $cliente->save();
                return response()->json($cliente, 200);
            } else {
                return response()->json(['message' => 'Cliente no encontrado'], 404);
            }
        }

    }