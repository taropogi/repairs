<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpoLine extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function cpo()
    {
        return $this->belongsTo(Cpo::class);
    }
}