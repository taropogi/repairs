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

    protected $appends = ['formatted_id', 'is_completed', 'formatted_rma_number', 'lines_count', 'invalid_lines_count', 'valid_lines_count'];

    protected $cpoNumberPadZero;
    protected $rmaNumberPadZero;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->cpoNumberPadZero = config('global.cpoNumberPadZero');
        $this->rmaNumberPadZero = config('global.rmaNumberPadZero');
    }


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($cpo) {
    //         if(is_null($cpo->rma_number)){
    //             $maxRmaNumber = Cpo::where('rma_number', 'like', 'RMA-%')->max('rma_number');
    //         }
    //     });
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cpo) {
            if (auth()->check()) {
                $cpo->created_by = auth()->id();
            } else {
                throw new \Exception('User not authenticated');
            }
        });
    }


    public function lines()
    {
        return $this->hasMany(CpoLine::class)->orderBy('line_number', 'ASC');
    }

    public function getLinesCountAttribute()
    {
        return $this->lines->count();
    }

    public function getInvalidLinesCountAttribute()
    {
        return $this->lines->whereNull('description')->count();
    }

    public function getValidLinesCountAttribute()
    {
        return $this->lines->whereNotNull('description')->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
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
        return str_pad($this->id, $this->cpoNumberPadZero, '0', STR_PAD_LEFT);
    }

    // Accessor for formatted RMA Number
    public function getFormattedRmaNumberAttribute()
    {
        return $this->rma_number ?  str_pad($this->rma_number, $this->rmaNumberPadZero, '0', STR_PAD_LEFT) : '';
    }

    // Accessor for checking if the Cpo is completed
    public function getIsCompletedAttribute()
    {
        return $this->status_id == 6;
    }
}
