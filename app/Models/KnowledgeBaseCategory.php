// KnowledgeBaseCategory.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KbCategory extends Model {
  protected $table = 'kb_categories';
  protected $fillable = ['name'];
  public function articles(){ return $this->hasMany(KbArticle::class); }
}
