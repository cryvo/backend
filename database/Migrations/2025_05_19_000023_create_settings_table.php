<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key','value'];
    protected $casts = ['value'=>'array'];

    public static function get(string $key, $default = [])
    {
        return static::firstOrCreate(['key'=>$key], ['value'=>$default])->value;
    }

    public static function set(string $key, array $value)
    {
        return static::updateOrCreate(['key'=>$key], ['value'=>$value]);
    }
}
