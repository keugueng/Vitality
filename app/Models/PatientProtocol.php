<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProtocol extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id','program_id','notes','status','sessions_done','progress_percent','assigned_at','completed_at'];
    protected $casts = ['assigned_at'=>'datetime','completed_at'=>'datetime'];

    public function patient() { return $this->belongsTo(Patient::class); }
    public function program() { return $this->belongsTo(Program::class); }
}
