<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',      // minuscule
                'regex:/[A-Z]/',      // majuscule
                'regex:/[0-9]/',      // chiffre
                'regex:/[@$!%*#?&.]/'  // caractère spécial
            ]
        ]);

        Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user, $password) {

                // Empêcher ancien mot de passe
                if (Hash::check($password, $user->password)) {
                    throw ValidationException::withMessages([
                        'password' => 'Vous ne pouvez pas utiliser votre ancien mot de passe.'
                    ]);
                }

                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return redirect()->route('login')
            ->with('success','Mot de passe réinitialisé');
    }

    
}
