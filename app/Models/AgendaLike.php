<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaLike extends Model
{
    protected $fillable = ['agenda_id', 'user_id'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
