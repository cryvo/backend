<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // GET /api/v1/user/profile
    public function show(Request $r)
    {
        return response()->json($r->user()->only(['name','email','phone','avatar_url']));
    }

    // PUT /api/v1/user/profile
    public function update(Request $r)
    {
        $data = $r->validate([
          'name'  => 'sometimes|string',
          'email' => 'sometimes|email|unique:users,email,'.$r->user()->id,
          'phone' => 'sometimes|string|unique:users,phone,'.$r->user()->id,
        ]);
        $r->user()->update($data);
        return response()->json($r->user());
    }

    // POST /api/v1/user/avatar
    public function updateAvatar(Request $r)
    {
        $r->validate([ 'avatar'=>'required|image|max:5120' ]);  // up to 5MB
        $path = $r->file('avatar')->store('avatars','public');
        // delete old?
        if ($r->user()->avatar_url) {
          Storage::disk('public')->delete($r->user()->avatar_url);
        }
        $r->user()->update(['avatar_url'=>$path]);
        return response()->json(['avatar_url'=>Storage::url($path)]);
    }
}
