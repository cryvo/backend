<?php
// app/Http/Controllers/LandingController.php
namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug',$slug)
                    ->where('is_active',true)
                    ->firstOrFail();

        return view('landing.show', compact('page'));
    }
}
