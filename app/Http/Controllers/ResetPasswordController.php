<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon; // Agregamos la importación de Carbon
use App\Models\PasswordReset;
//use App\Mail\ResetPasswordMail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;


class ResetPasswordController extends Controller
{ 

    public function resetPasswordView($token){
        try {
            $tokenData = PasswordReset::where('token', $token)->first();
                if ($tokenData->token === $token) {
                    // Define the expiration time (e.g., 2 hour)
                $expirationTime = now()->subHour(2);
                // Check if the token's creation time is within the expiration period
                if ($tokenData->created_at->gt($expirationTime)) {

                    return view('emails.resetPassword', ['token' => $tokenData->token]);
                } else {
                    return response()->json(['error' => 'El token ha expirado'], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json(['error' => 'El token no coincide con el registrado'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            // Handle unexpected errors
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Error inesperado'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
   
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:8|confirmed',
                'token' => 'required',
            ]);
    
            $user = User::where('email', $request->email)->first();
    
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
            }
    
            $token = $request->token;
            $tokenData = PasswordReset::where('token', $token)->first();
    
            if ($tokenData && $tokenData->token == $token) {
                $expirationTime = now()->subHour(2);
    
                if ($tokenData->created_at->gt($expirationTime)) {
                    Password::reset(
                        array_merge($request->only('email', 'password', 'password_confirmation', 'token')),
                        function ($user, $password) {
                            $user->password = Hash::make($password);
                            $user->save();
                        }
                    );
    
                    Mail::send('emails.resetEmailPassword', ['user' => $user], function ($message) use ($user) {
                        $message->to($user->email)->subject('Password Reset Successful');
                    });
    
                    return view('emails.resetPassword', ['token' => $tokenData->token]);
                } else {
                    \Log::error('El token ha expirado');
                    return response()->json(['error' => 'El token ha expirado'], Response::HTTP_BAD_REQUEST);
                }
            } else {
                \Log::error('El token no existe');
                return response()->json(['error' => 'El token no existe'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Unexpected error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}