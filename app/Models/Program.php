<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id','title','title_fr','slug','emoji','short_desc','short_desc_fr',
        'long_desc','long_desc_fr','session_duration','cure_duration','price',
        'is_bestseller','is_active','is_featured','benefits','tags','image','audio_url','sort_order'
    ];

    protected $casts = [
        'is_bestseller' => 'boolean',
        'is_active'     => 'boolean',
        'is_featured'   => 'boolean',
        'benefits'      => 'array',
        'tags'          => 'array',
        'price'         => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function userPrograms()
    {
        return $this->hasMany(UserProgram::class);
    }

    public function patientProtocols()
    {
        return $this->hasMany(PatientProtocol::class);
    }
}
