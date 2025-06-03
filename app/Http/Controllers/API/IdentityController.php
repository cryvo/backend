<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IdentityDocument;
use Illuminate\Support\Facades\Storage;

class IdentityController extends Controller
{
    public function index(Request $r)
    {
        return $r->user()->identityDocuments;
    }

    public function upload(Request $r)
    {
        $r->validate([
          'type'=>'required|in:passport,id_card,driver_license',
          'document'=>'required|file|mimes:jpg,png,pdf|max:10240'
        ]);

        $path = $r->file('document')->store('identity','public');
        $doc = IdentityDocument::create([
          'user_id'=>$r->user()->id,
          'type'=>$r->type,
          'file_path'=>$path
        ]);
        return response()->json($doc,201);
    }
}
