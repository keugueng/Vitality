<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgram extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','program_id','order_id','access_link','expires_at','listen_count','last_listened_at'];
    protected $casts = ['expires_at'=>'datetime','last_listened_at'=>'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function program() { return $this->belongsTo(Program::class); }
    public function order() { return $this->belongsTo(Order::class); }
}
