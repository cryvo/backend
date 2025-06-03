<?php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * List all users with basic info.
     */
    public function index()
    {
        $users = User::select('id','uid','name','email','is_active','kyc_status')
                     ->orderBy('created_at','desc')
                     ->get();

        return response()->json($users);
    }

    /**
     * Enable/disable or update user attributes.
     * Accepts JSON body: { is_active: bool }
     */
    public function update(Request $r, User $user)
    {
        $r->validate(['is_active'=>'required|boolean']);

        $user->is_active = $r->is_active;
        $user->save();

        return response()->json(['success'=>true,'is_active'=>$user->is_active]);
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success'=>true]);
    }
}
