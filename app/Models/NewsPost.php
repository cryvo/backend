// NewsPost.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NewsPost extends Model {
  protected $fillable = [
    'category_id','title','slug','content','image','status'
  ];
  public function category(){ return $this->belongsTo(NewsCategory::class); }
}
