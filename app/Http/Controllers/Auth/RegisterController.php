<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Biscolab\ReCaptcha\Facades\ReCaptcha;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // 1) Validate input + reCAPTCHA
        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|unique:users',
            'password'             => 'required|confirmed|min:8',
            'g-recaptcha-response' => 'required',
        ]);

        // 2) Verify the reCAPTCHA token
        $recap = ReCaptcha::verify($request->input('g-recaptcha-response'));
        if (! $recap->isSuccess()) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed']);
        }

        // 3) Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect('/home');
    }
}
