<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface CpoRepositoryInterface
{
    public function getCpoTally();
    public function store();
}
