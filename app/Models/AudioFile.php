<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioFile extends Model
{
    protected $fillable = [
        'title', 'filename', 'file_path', 'file_size',
        'duration', 'program_id', 'is_active', 'play_count',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'file_size'  => 'integer',
        'duration'   => 'integer',
        'play_count' => 'integer',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /** Duration formatted as "18:00" */
    public function getDurationFormattedAttribute(): string
    {
        $m = intdiv($this->duration, 60);
        $s = $this->duration % 60;
        return sprintf('%d:%02d', $m, $s);
    }

    /** File size formatted as "24 MB" */
    public function getFileSizeFormattedAttribute(): string
    {
        if ($this->file_size >= 1024 * 1024) {
            return round($this->file_size / (1024 * 1024)) . ' MB';
        }
        return round($this->file_size / 1024) . ' KB';
    }
}
