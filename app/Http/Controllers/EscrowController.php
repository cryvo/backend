<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escrow;

class EscrowController extends Controller
{
    // List all escrows for current user
    public function index()
    {
        $userId = auth()->id();
        $escrows = Escrow::where(function($q) use($userId){
            $q->where('buyer_id',$userId)
              ->orWhere('seller_id',$userId);
        })->with(['trade','buyer','seller'])
          ->latest()->paginate(10);

        return response()->json($escrows);
    }

    // Show single escrow
    public function show(Escrow $escrow)
    {
        $this->authorize('view', $escrow);
        return response()->json($escrow->load(['trade','buyer','seller']));
    }

    // Confirm receipt (buyer or seller)
    public function confirm(Request $r, Escrow $escrow)
    {
        $userId = auth()->id();
        $field = null;
        if ($userId === $escrow->buyer_id)  $field = 'buyer_confirmed';
        if ($userId === $escrow->seller_id) $field = 'seller_confirmed';
        if (! $field) return abort(403);

        $escrow->update([$field => true]);

        // auto-release if both confirmed
        if ($escrow->canRelease()) {
            $escrow->release();
        }

        return response()->json($escrow);
    }
}
