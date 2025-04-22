<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;    
use App\Models\Cliente;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    // Redirigir a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Manejar el callback de Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = Cliente::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->user['given_name'],
                    'apellidos' => $googleUser->user['family_name'] ?? '',
                    //'google_id' => $googleUser->id,
                    'is_google_user' => true,
                    'password' => null, 
                    'email_verified_at' => now(),
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return redirect()->away(env('FRONTEND_URL') . '/auth/callback?' . http_build_query([
                'user' => json_encode($user),
                'token' => $token
            ]));

        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->away(env('FRONTEND_URL') . '/login?error=google_auth_failed');
        }
    }
}


