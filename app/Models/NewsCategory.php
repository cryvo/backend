// NewsCategory.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NewsCategory extends Model {
  protected $fillable = ['name'];
  public function posts(){ return $this->hasMany(NewsPost::class); }
}
