<?php
// app/Http/Controllers/API/AuthController.php

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class AuthController extends Controller
{
    // POST /api/v1/auth/verify-phone
    public function verifyPhone(Request $r, FirebaseService $fb)
    {
        $claims = $fb->verifyIdToken($r->input('id_token'));
        $phone  = $claims['phone_number'] ?? null;
        if (!$phone) abort(422, 'Phone not verified by Firebase');
        $user = $r->user();
        $user->update(['phone'=>$phone]);
        return response()->json(['phone'=>$phone]);
    }

    // POST /api/v1/auth/verify-email
    public function verifyEmail(Request $r, FirebaseService $fb)
    {
        $claims = $fb->verifyIdToken($r->input('id_token'));
        $email  = $claims['email'] ?? null;
        if (!$email) abort(422, 'Email not verified by Firebase');
        $user = $r->user();
        $user->update(['email_verified_at'=>now()]);
        return response()->json(['email'=>$email]);
    }
}
    public function google(Request $r, FirebaseService $fb)
{
    $claims = $fb->verifyIdToken($r->id_token);
    $email  = $claims['email'] ?? abort(422);
    $user   = User::firstOrCreate(['email'=>$email], ['name'=>$claims['name']]);
    $token  = $user->createToken('api')->plainTextToken;
    return response()->json(['token'=>$token]);
}
    public function apple(Request $r, FirebaseService $fb)
{
    $claims = $fb->verifyIdToken($r->id_token);
    $email  = $claims['email'] ?? abort(422);
    $user   = User::firstOrCreate(['email'=>$email], ['name'=>$claims['name']]);
    $token  = $user->createToken('api')->plainTextToken;
    return response()->json(['token'=>$token]);
}