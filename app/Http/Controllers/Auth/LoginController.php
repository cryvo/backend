<?php
// app/Http/Controllers/Auth/LoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Auth;
use Biscolab\ReCaptcha\Facades\ReCaptcha;

class LoginController extends Controller
{
    // after credentials are valid:
    protected function authenticated(Request $request, $user)
    {
        // generate & email the code
        $user->two_factor_code = rand(100000, 999999);
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new TwoFactorCodeMail($user->two_factor_code));

        auth()->logout();
        session(['two_factor_user_id' => $user->id]);

        return redirect()->route('2fa.index');
    }
}


class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1) Validate credentials + reCAPTCHA
        $request->validate([
            'email'                => 'required|email',
            'password'             => 'required|string',
            'g-recaptcha-response' => 'required',
        ]);

        // 2) Verify the reCAPTCHA token
        $recap = ReCaptcha::verify($request->input('g-recaptcha-response'));
        if (! $recap->isSuccess()) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed']);
        }

        // 3) Attempt login
        if (Auth::attempt($request->only('email','password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
