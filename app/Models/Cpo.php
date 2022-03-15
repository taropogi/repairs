<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lines()
    {
        return $this->hasMany(CpoLines::class);
    }
}