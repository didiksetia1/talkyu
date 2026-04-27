<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $fillable = [
        'aspirasi_event_id', 'user_id', 'kategori', 'judul', 'deskripsi', 'tujuan_manfaat', 'lampiran', 'is_anonim', 'status', 'bem_response', 'votes_count', 'comments_count'
    ];

    // Kategori Aspirasi
    const CATEGORIES = [
        'akademik' => 'Akademik',
        'fasilitas' => 'Fasilitas',
        'kesejahteraan' => 'Kesejahteraan Mahasiswa',
        'kegiatan' => 'Kegiatan',
        'lingkungan' => 'Lingkungan Kampus',
        'teknologi' => 'Teknologi & Sistem',
        'lainnya' => 'Lainnya',
    ];

    public function event()
    {
        return $this->belongsTo(AspirasiEvent::class, 'aspirasi_event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
