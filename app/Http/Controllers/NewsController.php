// NewsController.php
<?php
namespace App\Http\Controllers;
use App\Models\NewsPost;
class NewsController extends Controller {
  public function index(){ 
    return NewsPost::where('status','published')->with('category')->paginate(10);
  }
  public function show($slug){
    return NewsPost::where('slug',$slug)->with('category')->firstOrFail();
  }
}
