<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspirasiComment extends Model
{
    protected $table = 'aspirasi_comments';

    protected $fillable = ['aspirasi_id', 'user_id', 'text'];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'aspirasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
