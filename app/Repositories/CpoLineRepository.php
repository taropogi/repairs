<?php

namespace App\Repositories;

use App\Models\CpoLine;
use App\Models\CpoLineComment;

class CpoLineRepository implements CpoLineRepositoryInterface
{
    public function update($lineId, $lineNumber, $lineData)
    {

        $userPermissions = auth()->user()->permissions ?? [];
        $userIsAdmin = auth()->user()->is_admin;
        $lineFields = [];
        foreach ($userPermissions as $permission) {
            if ($permission['name'] === 'cpo-edit') {
                $lineFields = $permission['lineFields'];
                break;
            }
        }


        $item = $lineData;
        $itemObj = (object)$item;

        $cpoLine = CpoLine::find($itemObj->id);
        $cpoLine->line_number = $lineNumber;

        if (in_array('description', $lineFields) || $userIsAdmin) {
            $cpoLine->description = $itemObj->description;
        }


        if ((in_array('price', $lineFields) || $userIsAdmin) && isset($itemObj->price) && is_numeric($itemObj->price)) {
            $cpoLine->price = $itemObj->price;
        }
        if (in_array('hcopy', $lineFields) || $userIsAdmin) {
            $cpoLine->hcopy = $itemObj->hcopy;
        }

        if (in_array('doc_date', $lineFields) || $userIsAdmin) {
            $cpoLine->doc_date = $itemObj->doc_date;
        }


        if ((in_array('qty_returned', $lineFields) || $userIsAdmin) && isset($itemObj->qty_returned) && is_numeric($itemObj->qty_returned)) {
            $cpoLine->qty_returned = $itemObj->qty_returned;
        }

        if (
            (in_array('unit', $lineFields) || $userIsAdmin) && isset($itemObj->unit)

        ) {
            $cpoLine->unit = $itemObj->unit;
        }

        if ((in_array('qty_inspect', $lineFields) || $userIsAdmin) && isset($itemObj->qty_inspect) && is_numeric($itemObj->qty_inspect)) {
            $cpoLine->qty_inspect = $itemObj->qty_inspect;
        }

        if (in_array('date_inspected', $lineFields) || $userIsAdmin) {
            $cpoLine->date_inspected = $itemObj->date_inspected;
        }

        if (
            (in_array('date', $lineFields) || $userIsAdmin)
        ) {
            $cpoLine->date = $itemObj->date;
        }

        if ((in_array('good_condition', $lineFields) || $userIsAdmin) && isset($itemObj->good_condition) && is_numeric($itemObj->good_condition)) {
            $cpoLine->good_condition = $itemObj->good_condition;
        }


        if ((in_array('minor_repair_clean', $lineFields) || $userIsAdmin) && isset($itemObj->minor_repair_clean) && is_numeric($itemObj->minor_repair_clean)) {
            $cpoLine->minor_repair_clean = $itemObj->minor_repair_clean;
        }
        if ((in_array('repair_parts_needed', $lineFields) || $userIsAdmin) && isset($itemObj->repair_parts_needed) && is_numeric($itemObj->repair_parts_needed)) {
            $cpoLine->repair_parts_needed = $itemObj->repair_parts_needed;
        }

        if ((in_array('damaged', $lineFields) || $userIsAdmin) && isset($itemObj->damaged) && is_numeric($itemObj->damaged)) {
            $cpoLine->damaged = $itemObj->damaged;
        }

        // $cpoLine->comments = $itemObj->comments;

        if (
            (in_array('order_number', $lineFields) || $userIsAdmin)
        ) {
            $cpoLine->order_number = $itemObj->order_number;
        }

        $cpoLine->update();

        // update comment in cpo_line_comments table
        if (in_array('comments', $lineFields) || $userIsAdmin) {
            $cpoLineComment = CpoLineComment::firstOrNew(['cpo_line_id' => $cpoLine->id, 'user_id' => auth()->user()->id]);

            if (($itemObj->user_comment == '')) {
                $cpoLineComment->delete();
            } else {
                $cpoLineComment->user_id = auth()->user()->id;
                $cpoLineComment->comment = $itemObj->user_comment ?? '';
                $cpoLineComment->commented_by = auth()->user()->name;
                $cpoLineComment->save();
            }
        }

        return CpoLine::find($lineId);
    }

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
