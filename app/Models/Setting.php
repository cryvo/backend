<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
// app/Models/Setting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['section','config'];
    protected $casts    = ['config'=>'array'];
}


class SettingsController extends Controller
{
    // GET  /api/v1/admin/settings/{section}
    public function show($section)
    {
        $data = Setting::get($section);
        return response()->json($data);
    }

    // PUT  /api/v1/admin/settings/{section}
    public function update(Request $r, $section)
    {
        $payload = $r->all(); // e.g. ['site_name'=>'Cryvo', 'url'=>'https://cryvo.io', ...]
        Setting::set($section, $payload);
        return response()->json(['success' => true]);
    }
}
