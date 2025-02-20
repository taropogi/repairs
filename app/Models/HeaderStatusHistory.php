<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderStatusHistory extends Model
{
    use HasFactory;
    protected $guarded = [];
    //protected $with = ['changed_by'];

    public function cpos()
    {
        return $this->hasMany(Cpo::class);
    }

    public function changed_by()
    {
        return $this->belongsTo(User::class);
    }
}