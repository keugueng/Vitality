<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','type','price','status','payment_intent','starts_at','ends_at','cancelled_at'];
    protected $casts = ['price'=>'decimal:2','starts_at'=>'datetime','ends_at'=>'datetime','cancelled_at'=>'datetime'];

    public function user() { return $this->belongsTo(User::class); }

    public function isActive(): bool
    {
        return $this->status === 'active' && ($this->ends_at === null || $this->ends_at->isFuture());
    }
}
