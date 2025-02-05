<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($activity) {
        //     $activity->client_ip = Request::ip();
        //     $activity->user_agent = Request::header('User-Agent');
        // });

        static::creating(function ($activity) {
            $activity->action_by = Auth::check() ? Auth::user()->name : 'SYSTEM';
            $activity->ip_address = Request::ip();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
