<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class,'user');
    }

    public function index()
    {
        return User::paginate(20);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
        ]);
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>"required|email|unique:users,email,{$user->id}",
        ]);
        $user->update($data);
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response(null,204);
    }
}
