<?php
// app/Http/Controllers/Auth/TwoFactorController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.2fa');
    }

    public function store(Request $request)
    {
        $request->validate(['code'=>'required|numeric']);

        $user = User::find(session('two_factor_user_id'));

        if (! $user ||
            $user->two_factor_expires_at->lt(now()) ||
            $user->two_factor_code !== $request->code) {
            return back()->withErrors(['code'=>'Invalid or expired code']);
        }

        // clear and log in
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        auth()->login($user);

        return redirect()->intended('/home');
    }
}
