<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Agenda extends Model
{
    public const CATEGORIES = [
        'Kalender & Agenda Akademik',
        'Event & Kegiatan Akademik',
    ];

    protected $fillable = ['title', 'category', 'content', 'image_url', 'image_path'];

    protected $appends = ['image_source'];

    public function getImageSourceAttribute(): ?string
    {
        if (!empty($this->image_path) && Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }

        return $this->image_url;
    }

    public function comments()
    {
        return $this->hasMany(AgendaComment::class)->latest();
    }

    public function likes()
    {
        return $this->hasMany(AgendaLike::class);
    }
}
