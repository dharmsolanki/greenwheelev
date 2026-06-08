<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $fillable = ['order_no','name','phone','email','address','city','state','pincode','payment_method','payment_id','razorpay_order_id','status','subtotal','shipping','total','notes'];
    protected $casts = ['subtotal'=>'decimal:2','shipping'=>'decimal:2','total'=>'decimal:2'];
    public function items() { return $this->hasMany(OrderItem::class); }
    public function getStatusBadgeAttribute() {
        return ['pending'=>'warning','confirmed'=>'info','processing'=>'primary','shipped'=>'info','delivered'=>'success','cancelled'=>'danger'][$this->status] ?? 'secondary';
    }
    public static function generateOrderNo() { return 'GWE'.strtoupper(substr(md5(uniqid()),0,6)); }
}
