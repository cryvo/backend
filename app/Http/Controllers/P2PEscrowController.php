<?php
namespace App\Http\Controllers;
use App\Models\P2PTrade;
use Illuminate\Http\Request;

class P2PEscrowController extends Controller
{
    // Buyer confirms receipt → release escrow
    public function release(Request $r, P2PTrade $trade)
    {
        $this->authorize('view',$trade);
        if(auth()->id() !== $trade->buyer_id){
            abort(403);
        }
        if($trade->releaseEscrow()){
            return response()->json(['message'=>'Escrow released'],200);
        }
        return response()->json(['message'=>'Already handled'],400);
    }

    // Admin marks disputed
    public function dispute(Request $r, P2PTrade $trade)
    {
        $this->authorize('isAdmin');
        $trade->update(['escrow_status'=>'disputed']);
        return response()->json(['message'=>'Trade marked disputed'],200);
    }
}
