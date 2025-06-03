// BlogController.php
<?php
namespace App\Http\Controllers;
use App\Models\BlogPost;
class BlogController extends Controller {
  public function index(){ 
    return BlogPost::where('status','published')->with('category')->paginate(10);
  }
  public function show($slug){
    return BlogPost::where('slug',$slug)->with('category')->firstOrFail();
  }
}
