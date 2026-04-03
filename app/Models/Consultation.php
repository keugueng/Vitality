<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name','email','phone','package_type','sessions_count','amount',
        'symptoms','medical_history','status','payment_intent','payment_status',
        'protocol_notes','protocol_url','delivered_at'
    ];
    protected $casts = ['amount'=>'decimal:2','delivered_at'=>'datetime'];

    public function user() { return $this->belongsTo(User::class); }
}
