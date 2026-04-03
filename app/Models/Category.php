<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','name_fr','slug','emoji','color','description','sort_order','is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
