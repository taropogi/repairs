<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpoLines extends Model
{
    use HasFactory;

    public function cpo()
    {
        return $this->belongsTo(Cpo::class);
    }
}