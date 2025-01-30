<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
    ];


    public function created_pdfs()
    {
        return $this->hasMany(CpoPdfHistory::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function changed_header_status_history()
    {
        return $this->hasMany(HeaderStatusHistory::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermissionTo($permission)
    {
        if ($this->is_admin) {
            return true;
        }

        foreach ($this->permissions as $perm) {


            if ($perm['name'] === $permission) {
                return true;
            }
        }
        return false;
    }

    public function canAccessOtherCpos()
    {
        return $this->hasPermissionTo('access-other-cpo');
    }

    public function hasPermission($permission)
    {
        if ($this->is_admin) {
            return true;
        }
        $permissions = $this->permissions ?? [];
        return in_array($permission, $permissions);
    }

    public function cpo_line_comments()
    {
        return $this->hasMany(CpoLineComment::class);
    }

    public function cpos()
    {
        return $this->hasMany(Cpo::class, 'created_by');
    }
}
