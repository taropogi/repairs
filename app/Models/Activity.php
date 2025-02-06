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
            if (empty($activity->action_by)) {
                $activity->action_by = Auth::check() ? Auth::user()->name : 'SYSTEM';
            }
            if (empty($activity->ip_address)) {
                $activity->ip_address = Request::ip() ?? 'SYSTEM';
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
