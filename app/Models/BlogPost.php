<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class BlogPost extends Model {
    protected $fillable = ['title','slug','excerpt','content','image','category','author','is_published','published_at'];
    protected $casts = ['is_published'=>'boolean','published_at'=>'datetime'];
    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?? Str::slug($m->title));
    }
    public function scopePublished($q) { return $q->where('is_published',true); }
}
