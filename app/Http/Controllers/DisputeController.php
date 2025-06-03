<?php
namespace App\Http\Controllers;

use App\Models\Dispute;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    // List disputes for current user
    public function index()
    {
        $disputes = Dispute::where('user_id', auth()->id())
            ->with('trade')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($disputes);
    }

    // Create new dispute
    public function store(Request $r)
    {
        $data = $r->validate([
            'trade_id' => 'required|exists:p2p_trades,id',
            'reason'   => 'required|string|max:255',
            'message'  => 'nullable|string',
        ]);
        $data['user_id'] = auth()->id();

        $dispute = Dispute::create($data);
        return response()->json($dispute, 201);
    }

    // Show single dispute
    public function show(Dispute $dispute)
    {
        $this->authorize('view', $dispute);
        return response()->json($dispute->load('trade','user'));
    }

    // Update status (admin)
    public function update(Request $r, Dispute $dispute)
    {
        $r->validate([
            'status' => 'required|in:open,under_review,resolved,rejected'
        ]);
        $dispute->status = $r->status;
        $dispute->save();
        return response()->json($dispute);
    }
}
