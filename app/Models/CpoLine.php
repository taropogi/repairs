<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpoLine extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['user_comment', 'all_comments', 'other_comments'];
    public function cpo()
    {
        return $this->belongsTo(Cpo::class);
    }

    public function comments()
    {
        return $this->hasMany(CpoLineComment::class);
    }

    public function getAllCommentsAttribute()
    {
        return $this->comments()->get();
    }

    public function getOtherCommentsAttribute()
    {
        return $this->comments()->where('user_id', '!=', auth()->user()->id)->get();
    }

    public function getUserCommentAttribute()
    {
        $userComment = $this->comments()->where('user_id', auth()->user()->id)->first();
        if ($userComment) {
            return $userComment->comment;
        }

        return '';
    }
}
