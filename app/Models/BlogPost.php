// BlogPost.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BlogPost extends Model {
  protected $fillable = [
    'category_id','title','slug','excerpt','content','image','status'
  ];
  public function category(){ return $this->belongsTo(BlogCategory::class); }
}
