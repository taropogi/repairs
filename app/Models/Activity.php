<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            $activity->action_by = Auth::check() ? Auth::user()->name : 'SYSTEM';
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
