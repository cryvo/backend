<?php
// File: backend/app/Http/Controllers/API/UserController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Download the authenticated user’s KYC document or selfie.
     *
     * @param  Request  $request
     * @param  string   $type   'document' or 'selfie'
     */
    public function downloadKyc(Request $request, $type)
    {
        $user = Auth::user();
        if (! in_array($type, ['document','selfie'])) {
            abort(404);
        }

        $path = $type === 'document'
            ? $user->kyc_document_path
            : $user->kyc_selfie_path;

        if (! $path || ! Storage::disk('private')->exists($path)) {
            abort(404);
        }

        return Storage::disk('private')->download($path);
    }
}
