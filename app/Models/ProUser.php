<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','specialty','license_number','clinic_name','commission_rate','total_commissions','status'];
    protected $casts = ['commission_rate'=>'decimal:2','total_commissions'=>'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
    public function patients() { return $this->hasMany(Patient::class); }
}
