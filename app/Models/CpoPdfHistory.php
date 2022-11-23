<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpoPdfHistory extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function cpo()
    {
        return $this->belongsTo(Cpo::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
}