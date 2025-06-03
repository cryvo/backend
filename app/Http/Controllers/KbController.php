// KbController.php
<?php
namespace App\Http\Controllers;
use App\Models\KbArticle;
class KbController extends Controller {
  public function index(){
    return KbArticle::with('category')->get();
  }
  public function show($slug){
    return KbArticle::where('slug',$slug)->with('category')->firstOrFail();
  }
}
