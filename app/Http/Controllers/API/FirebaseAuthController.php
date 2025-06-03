<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\FirebaseAuth;
use App\Models\User;

class FirebaseAuthController extends Controller
{
    public function authenticate(Request $r)
    {
        $r->validate(['token'=>'required|string']);
        $verified = FirebaseAuth::verifyIdToken($r->token);
        $uid = $verified->claims()->get('sub');
        $user = User::firstOrCreate(
            ['uid' => $uid],
            ['email' => $verified->claims()->get('email',''), 'name'=>'']
        );
        // create Laravel token
        $token = $user->createToken('firebase')->plainTextToken;
        return response()->json(['authToken'=>$token]);
    }
}
