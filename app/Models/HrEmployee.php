<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{

    protected $connection = 'hr';
    protected $table = 'hs_hr_employee';


    use HasFactory;
}
