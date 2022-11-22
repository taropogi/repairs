<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OracleCustomer extends Model
{

    protected $connection = 'admin';
    protected $table = 'tblHCA_Final';

    use HasFactory;
}