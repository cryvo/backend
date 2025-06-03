// KbArticle.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KbArticle extends Model {
  protected $table = 'kb_articles';
  protected $fillable = ['category_id','title','slug','content'];
  public function category(){ return $this->belongsTo(KbCategory::class); }
}
