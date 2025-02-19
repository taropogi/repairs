<?php

namespace App\Repositories;

interface CpoLineRepositoryInterface
{

    public function store($cpoId, $lineData);
    public function update($lineId, $lineNumber, $lineData);
}
