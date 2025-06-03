<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    public function index(Request $r) {
        return $r->user()->apiKeys()->get();
    }

    public function store(Request $r) {
        $r->validate(['name'=>'required']);
        $key = Str::random(40);
        $apiKey = ApiKey::create([
          'user_id'=>$r->user()->id,
          'name'=>$r->name,
          'key'=>$key
        ]);
        return response()->json($apiKey,201);
    }

    public function destroy(Request $r, ApiKey $apiKey) {
        $this->authorize('delete',$apiKey);
        $apiKey->update(['revoked_at'=>now()]);
        return response(null,204);
    }
}
