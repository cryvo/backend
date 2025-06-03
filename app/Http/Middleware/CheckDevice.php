<?php
// app/Http/Middleware/CheckDevice.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Device;
use Kreait\Firebase\Auth as FirebaseAuth;

class CheckDevice
{
    protected $firebase;
    public function __construct(FirebaseAuth $firebase) { $this->firebase = $firebase; }

    public function handle(Request $req, Closure $next)
    {
        $user = $req->user();
        $fingerprint = sha1($req->ip() . '|' . $req->header('User-Agent'));
        $known = $user->devices()->where('fingerprint',$fingerprint)->exists();

        if (! $known) {
            // Send SMS OTP
            $phone = $user->phone;      // assume E.164 stored
            $this->firebase->sendSmsVerification($phone);

            // Send Email OTP
            $emailLink = $this->firebase->getEmailSignInLink($user->email);
            Mail::to($user->email)->send(new VerifyEmailLink($emailLink));

            // Store device after verification completed in controller
            session(['pending_device_fp'=>$fingerprint]);
            return redirect()->route('verify.otp');
        }

        return $next($req);
    }
}
