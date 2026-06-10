<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Scooter extends Model {
    protected $fillable = ['name','slug','category','icon','range','top_speed','charging_time','motor_power','price','description','features','image','is_active','is_featured','tag'];
    protected $casts = ['features'=>'array','is_active'=>'boolean','is_featured'=>'boolean','price'=>'decimal:2'];
    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?? Str::slug($m->name));
    }
    public function images() { return $this->hasMany(ScooterImage::class)->orderBy('sort_order'); }
    public function primaryImage() { return $this->hasOne(ScooterImage::class)->where('is_primary',true); }
    public function scopeActive($q) { return $q->where('is_active',true); }
    public function getCategoryLabelAttribute() {
        return ['city'=>'City Commuter','premium'=>'Premium','longrange'=>'Long Range','highspeed'=>'High Speed','delivery'=>'Delivery EV'][$this->category] ?? $this->category;
    }
    public function getMainImageAttribute() {
        $primary = $this->images->where('is_primary',true)->first();
        $first   = $this->images->first();
        $img     = $primary ?? $first;
        return $img ? asset('storage/'.$img->image_path) : null;
    }
}
