<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cpo extends Model
{
    use HasFactory;
    use SoftDeletes;
    // public $timestamps = false;
    protected $guarded = [];
    protected $with = ['status', 'status_history', 'lines'];

    protected $appends = ['formatted_id', 'is_completed'];



    public function lines()
    {
        return $this->hasMany(CpoLine::class)->orderBy('line_number', 'ASC');
    }

    public function pdf_history()
    {
        return $this->hasMany(CpoPdfHistory::class);
    }


    public function status_history()
    {
        return $this->hasMany(HeaderStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function status()
    {
        return $this->belongsTo(HeaderStatus::class);
    }

    // Accessor for formatted ID
    public function getFormattedIdAttribute()
    {
        return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    // Accessor for checking if the Cpo is completed
    public function getIsCompletedAttribute()
    {
        return $this->status_id == 6;
    }
}
