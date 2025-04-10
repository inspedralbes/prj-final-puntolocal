<?php
    namespace App\Http\Controllers\Auth;

    use \App\Models\Cliente;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Auth\Events\Verified;

    class VerificationController extends Controller {
        public function verify(Request $request, $id, $hash) {
            $user = Cliente::findOrFail($id);

            if ($user->hasVerifiedEmail()) {
                return redirect()->away(env('FRONTEND_URL'))->with('message', 'Correo ya verificado.');
            }

            if (sha1($user->email) === $hash) {
                $user->markEmailAsVerified();
                event(new Verified($user));
                return redirect()->route('home')->with('message', 'Correo verificado con éxito.');
            }

            return redirect()->route('home')->with('error', 'El enlace de verificación no es válido.');
        }
    }