<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * GET /api/v1/notifications
     */
    public function index()
    {
        return response()->json(
            Auth::user()->notifications()->latest()->get()
        );
    }
}
