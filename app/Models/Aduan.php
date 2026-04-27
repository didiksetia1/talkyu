<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'judul',
        'deskripsi',
        'gambar',
        'status',
        'ditinjau_at',
        'diproses_at',
        'selesai_at',
        'tanggapan'
    ];

    protected $casts = [
        'ditinjau_at' => 'datetime',
        'diproses_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
