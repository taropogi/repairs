<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cpo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $with = ['status', 'status_history'];

    public function lines()
    {
        return $this->hasMany(CpoLine::class);
    }

    public function status_history()
    {
        return $this->hasMany(HeaderStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function status()
    {
        return $this->belongsTo(HeaderStatus::class);
    }
}