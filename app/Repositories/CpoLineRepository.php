<?php

namespace App\Repositories;

use App\Models\CpoLine;

class CpoLineRepository implements CpoLineRepositoryInterface
{
    public function store($cpoId, $lineData)
    {
        $item = $lineData;
        $line = new CpoLine();
        $line->line_number = $item['lineNumber'];
        $line->description = $item['description'] ?? null;

        $line->price = isset($item['price']) && is_numeric($item['price']) ? $item['price'] : null;
        $line->hcopy = $item['hcopy'] ?? null;
        $line->doc_date = $item['doc_date'] ?? null;
        $line->qty_returned = isset($item['qtyReturned']) && is_numeric($item['qtyReturned']) ? $item['qtyReturned'] : null;
        $line->date_inspected = $item['date_inspected'] ?? null;
        $line->unit = $item['unit'] ?? null;
        $line->qty_inspect = isset($item['qtyInspect']) && is_numeric($item['qtyInspect']) ? $item['qtyInspect'] : null;
        $line->date = $item['date'] ?? null;
        $line->good_condition = isset($item['goodCondition']) && is_numeric($item['goodCondition']) ? $item['goodCondition'] : null;
        $line->minor_repair_clean = isset($item['minorRepairClean']) && is_numeric($item['minorRepairClean']) ? $item['minorRepairClean'] : null;
        $line->repair_parts_needed = isset($item['repairPartsNeeded']) && is_numeric($item['repairPartsNeeded']) ? $item['repairPartsNeeded'] : null;
        $line->damaged = isset($item['damaged']) && is_numeric($item['damaged']) ? $item['damaged'] : null;
        $line->comments = $item['comments'] ?? null;
        $line->order_number = $item['orderNumber'] ?? null;
        $line->cpo_id = $cpoId;
        $line->save();

        return $line;
    }
}
