<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TestRideBooking extends Model {
    protected $fillable = ['name','phone','preferred_date','vehicle_interest','status'];
    protected $casts = ['preferred_date'=>'date'];
}
