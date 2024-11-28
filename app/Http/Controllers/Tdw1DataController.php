<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class Tdw1DataController extends Controller
{
    public function items_uom()
    {
        // get items from Item model 
        $response['items_uom'] = Item::select('primary_uom_code', 'primary_unit_of_measure')->distinct()->get();

        return $response;
    }
}
