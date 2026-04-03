<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id','title','title_fr','slug','excerpt','excerpt_fr','content','content_fr',
        'image','category','tags','read_time','is_published','published_at'
    ];
    protected $casts = ['tags'=>'array','is_published'=>'boolean','published_at'=>'datetime'];

    public function author() { return $this->belongsTo(User::class, 'author_id'); }

    public function getRouteKeyName() { return 'slug'; }
}
