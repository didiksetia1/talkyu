<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspirasiEvent extends Model
{
    protected $fillable = ['title', 'description', 'is_active'];

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class);
    }
}
