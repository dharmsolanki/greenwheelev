<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ScooterImage extends Model {
    protected $fillable = ['scooter_id','image_path','alt_text','is_primary','sort_order'];
    protected $casts = ['is_primary'=>'boolean'];
    public function scooter() { return $this->belongsTo(Scooter::class); }
}
