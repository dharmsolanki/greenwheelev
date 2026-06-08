<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DealerApplication extends Model {
    protected $fillable = ['name','phone','email','city','state','investment_capacity','showroom_space','status','admin_notes'];
}
