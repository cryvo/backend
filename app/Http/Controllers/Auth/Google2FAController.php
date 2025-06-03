<?php
// app/Http/Controllers/Auth/Google2FAController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Support\Constants;

class Google2FAController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (empty($user->google2fa_secret)) {
            $secret = app('pragmarx.google2fa')->generateSecretKey();
            $QR_Image = app('pragmarx.google2fa')->getQRCodeInline(
                config('app.name'),
                $user->email,
                $secret
            );
            $user->google2fa_secret = $secret;
            $user->save();
        } else {
            $QR_Image = app('pragmarx.google2fa')->getQRCodeInline(
                config('app.name'),
                $user->email,
                $user->google2fa_secret
            );
        }

        return view('auth.2fa-google', compact('QR_Image'));
    }

    public function verify(Request $request)
    {
        $request->validate(['one_time_password'=>'required|digits:6']);

        $valid = app('pragmarx.google2fa')->verifyKey(
            $request->user()->google2fa_secret,
            $request->one_time_password
        );

        if ($valid) {
            $request->user()->google2fa_enabled = true;
            $request->user()->save();
            return redirect('/home')->with('success','Google 2FA enabled');
        }

        return back()->withErrors(['one_time_password'=>'Invalid code']);
    }
}
