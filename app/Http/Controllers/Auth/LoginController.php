<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirect()
    {
        $redirect = Socialite::driver('google')->redirect();
        return $redirect;
        // return response()->json([
        //     'redirect_url' => $redirect->getTargetUrl()
        // ]);
    }

    public function callback()
    {
        $user = Socialite::driver('google')->user();

        $finduser = User::where('google_id', $user->id)->first();

        if (!$finduser) {
            //     Auth::login($finduser);
            // } else {
            $user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'password' => uniqid(), // you can change auto generate password here and send it via email but you need to add checking that the user need to change the password for security reasons
            ]);

            $finduser = User::find($user->id);

            Auth::login($user);
        }

        // Jika berhasil login
        if($user = $finduser){
            $token = $user->createToken('auth_token')->plainTextToken;
            return redirect(env('APP_FE_URL') . '/login/redirect?auth_token=' . $token);
        }
    }
}
