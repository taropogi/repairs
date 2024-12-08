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
    public function getItemsAll()
    {
        $query = Item::query();

        if (request()->has('search')) {
            $search = request()->input('search');
            $query->where('description', 'LIKE', "%{$search}%")
                ->orWhere('oracle_code', 'LIKE', "%{$search}%");
        }
        $response['items'] = $query->limit(200)->get();

        return $response;
    }
}
