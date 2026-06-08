<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Review extends Model {
    protected $fillable = ['name','location','rating','review','is_approved'];
    protected $casts = ['is_approved'=>'boolean'];
    public function scopeApproved($q) { return $q->where('is_approved',true); }
}
