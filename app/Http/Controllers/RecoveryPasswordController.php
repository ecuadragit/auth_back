<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;

class RecoveryPasswordController extends Controller
{
    public function forgetPasswordView(Request $request)
    {  
       // echo('mensaje');
         return view('emails.recoveryPassword');  
       // return response()->json(['status' => 'Recovery email sent successfully'], 200);
      
    }
    
    public function forgetPassword(Request $request)
    {  

        //return response()->json(['status' => 'Recovery email sent successfully'], 200);
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);
            $user = User::where('email', $request->email)->first();
            // Generate a unique recovery token
            $token = Str::random(33);

             // Insert or update the token in the password_resets table
             \DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => now()]
            );
          

            Mail::send('emails.recoveryEmailPassword', ['user' => $user,'token' => $token], function ($message) use ($user) {
                $message->to($user->email)->subject('Recuperación de cuenta');
            });
            
            // The recovery email was sent successfully
            return response()->json(['status' => 'Recovery email sent successfully'], 200);
            
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {

            \Log::error($e->getMessage());
            dd($e->getMessage(), $e->getTrace());
            return response()->json(['error' => 'Unexpected error'], Response::HTTP_INTERNAL_SERVER_ERROR);
            
        }
    }
   
}
