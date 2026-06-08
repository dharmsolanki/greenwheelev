<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OrderItem extends Model {
    protected $fillable = ['order_id','spare_part_id','part_name','price','qty','subtotal'];
    public function order() { return $this->belongsTo(Order::class); }
    public function part() { return $this->belongsTo(SparePart::class,'spare_part_id'); }
}
