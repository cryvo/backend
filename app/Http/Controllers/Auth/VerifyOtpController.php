<?php
// app/Http/Controllers/Auth/VerifyOtpController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;

class VerifyOtpController extends Controller
{
    public function show() { return view('auth.verify-otp'); }

    public function verify(Request $req)
    {
        $code = $req->input('otp');
        $user = auth()->user();

        // verify via Firebase
        if (! app('firebase.auth')->verifySmsCode($user->phone, $code)) {
            return back()->withErrors(['otp'=>'Invalid OTP']);
        }

        // mark device
        $fp = session('pending_device_fp');
        $user->devices()->create(['fingerprint'=>$fp]);
        return redirect()->intended('/');
    }
}
