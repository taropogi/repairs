<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface CpoRepositoryInterface
{

    public function store();
    public function getCpoTally();
    public function generateRmaNumber($cpoId);
}
