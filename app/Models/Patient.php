<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['pro_user_id','name','email','phone','age','gender','notes','medical_history','status'];

    public function proUser() { return $this->belongsTo(ProUser::class); }
    public function protocols() { return $this->hasMany(PatientProtocol::class); }
}
