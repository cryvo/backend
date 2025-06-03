<?php
namespace App\Services;

use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class FirebaseService
{
    protected FirebaseAuth $auth;
    public function __construct(FirebaseAuth $auth) {
        $this->auth = $auth;
    }

    /**
     * Verify a Firebase ID token and return the claims.
     */
    public function verifyIdToken(string $idToken): array
    {
        try {
            $verified = $this->auth->verifyIdToken($idToken);
            return $verified->claims()->all();
        } catch (FailedToVerifyToken $e) {
            abort(401, 'Invalid Firebase token');
        }
    }
}
