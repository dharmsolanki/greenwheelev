<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ServiceBooking extends Model {
    protected $fillable = ['name','phone','vehicle_brand','service_type','preferred_date','preferred_time','description','status','admin_notes'];
    protected $casts = ['preferred_date'=>'date'];
}
