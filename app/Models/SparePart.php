<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class SparePart extends Model {
    protected $fillable = ['name','slug','category','icon','price','mrp','stock','description','tag','image','is_active'];
    protected $casts = ['price'=>'decimal:2','mrp'=>'decimal:2','is_active'=>'boolean'];
    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?? Str::slug($m->name));
    }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function scopeActive($q) { return $q->where('is_active',true); }
    public function getDiscountPercentAttribute() {
        if(!$this->mrp || $this->mrp <= $this->price) return 0;
        return round((($this->mrp - $this->price) / $this->mrp) * 100);
    }
    public function getCategoryLabelAttribute() {
        return ['battery'=>'Battery','electrical'=>'Electrical','mechanical'=>'Mechanical','accessories'=>'Accessories'][$this->category] ?? $this->category;
    }
}
