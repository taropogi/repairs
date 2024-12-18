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

    public function getItemBySegment6()
    {
        $response['item'] = Item::where('segment6', request()->search)->first();
        return $response;
    }
    public function getItemsAll()
    {
        $query = Item::query();

        if (request()->has('search')) {
            $search = request()->input('search');
            $query->where('description', 'LIKE', "%{$search}%")
                ->orWhere('oracle_code', 'LIKE', "%{$search}%");

            $query->select('inventory_item_id', 'description', 'oracle_code', 'segment6', 'list_price', 'primary_unit_of_measure', 'primary_uom_code');
        }
        $response['items'] = $query->limit(30)->get();

        $response['items'] = $response['items']->map(function ($item) {

            $itemImageUrls = [];
            $remoteServer = env('YP_URL_PIC_DIR', 'http://113.1.1.190/phase7/pictures/');
            for ($x = 0; $x <= 5; $x++) {
                $src = "";
                if ($x == 0) {
                    $src = $remoteServer . $item->segment6 . '.jpg';
                } else {
                    $src = $remoteServer . $item->segment6 . '-0' . $x . '.jpg';
                }

                // $headers = @get_headers($src);

                // if ($headers && strpos($headers[0], '200') !== false) {
                //     array_push($itemImageUrls, $src);
                // }
                array_push($itemImageUrls, $src);
                // if ($this->remoteFileExists($src)) {
                //     array_push($itemImageUrls, $src);
                // }
            }

            $item->image_urls = $itemImageUrls;

            return $item;
        });

        usleep(200000);

        return $response;
    }

    private function remoteFileExists($url)
    {
        $ch = curl_init($url);

        // Set curl options
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout to avoid long waits
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        // Execute curl request
        curl_exec($ch);

        // Check HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close curl session
        curl_close($ch);

        // Return true if the HTTP response code is 200 (OK)
        return $httpCode === 200;
    }
}
