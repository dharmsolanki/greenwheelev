<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GalleryImage extends Model {
    protected $fillable = ['title','category','image_path','description','sort_order','is_active'];
    protected $casts = ['is_active'=>'boolean'];
    public function scopeActive($q) { return $q->where('is_active',true); }
}
