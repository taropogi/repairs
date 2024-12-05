<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpoLineComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cpoLine()
    {
        return $this->belongsTo(CpoLine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
