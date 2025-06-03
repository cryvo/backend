<?php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\KycStatusChanged;

class KycController extends Controller
{
    /** 
     * GET /api/v1/admin/kyc/pending 
     */
    public function index()
    {
        $pending = User::where('kyc_status','pending')
            ->select('id','uid','email','kyc_document_path','kyc_selfie_path')
            ->get();
        return response()->json($pending);
    }

    /** 
     * POST /api/v1/admin/kyc/{user}/status 
     * body: { status: 'approved'|'rejected' }
     */
    public function updateStatus(Request $r, User $user)
    {
        $r->validate(['status'=>'required|in:approved,rejected']);

        $user->kyc_status = $r->status;
        $user->save();

        // Notify the user
        $user->notify(new KycStatusChanged($r->status));

        return response()->json(['success'=>true,'status'=>$user->kyc_status]);
    }
}
