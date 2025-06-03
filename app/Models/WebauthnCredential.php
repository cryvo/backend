<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WebauthnCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\AttestationStatement\AndroidKeyAttestationStatementSupport;
use Webauthn\AuthenticatorAttestationResponseValidator;
use Webauthn\AuthenticatorAssertionResponseValidator;
use Webauthn\PublicKeyCredentialLoader;
use Base64Url\Base64Url;

class WebauthnController extends Controller
{
    protected $rpId = 'cryvo.io'; // change if needed
    protected $rpName = 'Cryvo';

    public function registerOptions(Request $r)
    {
        $user = User::where('email', $r->email)->firstOrFail();

        $creation = PublicKeyCredentialCreationOptions::create(
            $this->rpId,
            $this->rpName,
            Base64Url::decode($user->uid),
            $user->name,
            // no existing credentials in allowList
            [],
            ['usb','nfc','ble','internal'],
            'direct',
            ['attStmt'=>'none']
        );

        session(['webauthn_registration' => $creation]);

        return response()->json([
            'publicKey' => [
                'challenge'        => Base64Url::encode($creation->getChallenge()),
                'rp'               => $creation->getRp(),
                'user'             => [
                    'id'          => Base64Url::encode($creation->getUser()->getId()),
                    'name'        => $creation->getUser()->getName(),
                    'displayName' => $creation->getUser()->getDisplayName(),
                ],
                'pubKeyCredParams' => $creation->getPubKeyCredParams(),
                'timeout'          => $creation->getTimeout(),
                'attestation'      => $creation->getAttestation(),
                'authenticatorSelection' => $creation->getAuthenticatorSelection()->jsonSerialize(),
            ]
        ]);
    }

    public function registerVerify(Request $r)
    {
        $creation = session('webauthn_registration');
        if (! $creation) {
            return response()->json(['error'=>'No registration in progress'], 400);
        }

        $loader = new PublicKeyCredentialLoader();
        $credential = $loader->loadArray($r->all());

        $validator = new AuthenticatorAttestationResponseValidator(
            null,
            new AndroidKeyAttestationStatementSupport(),
            null,
            null
        );

        $attestation = $credential->getResponse();
        $publicKey = $validator->check(
            $attestation,
            $creation,
            $this->rpId
        );

        $user = Auth::user();
        WebauthnCredential::create([
            'user_id'       => $user->id,
            'credential_id'=> Base64Url::encode($credential->getRawId()),
            'public_key'   => Base64Url::encode($publicKey->getCredentialPublicKey()->getCose()),
            'counter'      => $attestation->getAuthenticatorData()->getSignCount(),
        ]);

        return response()->json(['success'=>true]);
    }

    public function authenticateOptions(Request $r)
    {
        $user = User::where('email', $r->email)->firstOrFail();
        $creds = WebauthnCredential::where('user_id', $user->id)->get();

        $allowList = $creds->map(function($c){
            return [
                'id'   => Base64Url::decode($c->credential_id),
                'type' => 'public-key',
            ];
        })->toArray();

        $requestOpts = PublicKeyCredentialRequestOptions::create(
            Base64Url::decode(random_bytes(32)),
            60000,
            $this->rpId,
            $allowList
        );

        session(['webauthn_authentication' => $requestOpts]);

        return response()->json([
            'publicKey' => [
                'challenge'           => Base64Url::encode($requestOpts->getChallenge()),
                'timeout'             => $requestOpts->getTimeout(),
                'rpId'                => $requestOpts->getRpId(),
                'allowCredentials'    => array_map(function($ac){
                    return [
                        'type' => $ac['type'],
                        'id'   => Base64Url::encode($ac['id']),
                    ];
                }, $allowList),
            ]
        ]);
    }

    public function authenticateVerify(Request $r)
    {
        $requestOpts = session('webauthn_authentication');
        if (! $requestOpts) {
            return response()->json(['error'=>'No authentication in progress'], 400);
        }

        $loader = new PublicKeyCredentialLoader();
        $credential = $loader->loadArray($r->all());

        $validator = new AuthenticatorAssertionResponseValidator(null, null);

        $assertion = $credential->getResponse();
        $publicKeyCred = PublicKeyCredentialCreationOptions::createFromSession($requestOpts);
        $user = WebauthnCredential::where('credential_id', Base64Url::encode($credential->getRawId()))->firstOrFail();

        $stored = WebauthnCredential::where('user_id', $user->user_id)->firstOrFail();
        $pk = Base64Url::decode($stored->public_key);

        $validator->check(
            $assertion,
            $requestOpts,
            $pk,
            $stored->counter
        );

        // update counter
        $stored->update(['counter'=>$assertion->getAuthenticatorData()->getSignCount()]);

        // issue Laravel token
        $laravelUser = \App\Models\User::findOrFail($stored->user_id);
        Auth::login($laravelUser);
        $token = $laravelUser->createToken('webauthn')->plainTextToken;

        return response()->json(['authToken'=>$token]);
    }
}
