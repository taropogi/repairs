<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\Item;
use App\Models\User;
use App\Traits\FormatLines;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Models\OracleCustomer;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    use FormatLines;
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function test()
    {
        $customers = OracleCustomer::all();

        $this->getItemsAll();
    }

    public function getItemsAll()
    {
        $query = Item::query();

        if (request()->has('search')) {
            $search = request()->input('search');
            $query->where('description', 'LIKE', "%{$search}%")
                ->orWhere('oracle_code', 'LIKE', "%{$search}%");

            $query->select('inventory_item_id', 'description', 'oracle_code', 'segment6');
        }
        $response['items'] = $query->limit(30)->get();

        $response['items']->map(function ($item) {

            $itemImageUrls = [];
            $remoteServer = env('YP_URL_PIC_DIR', 'http://113.1.1.190/phase7/pictures/');
            for ($x = 0; $x <= 5; $x++) {
                $src = "";
                if ($x == 0) {
                    $src = $remoteServer . $item->segment6 . '.jpg';
                } else {
                    $src = $remoteServer . $item->segment6 . '-0' . $x . '.jpg';
                }

                echo $src . " : <br>";

                // $headers = @get_headers($src);

                // if ($headers && strpos($headers[0], '200') !== false) {
                //     array_push($itemImageUrls, $src);
                // }

                if ($this->remoteFileExists($src)) {
                    echo 'has image';
                    array_push($itemImageUrls, $src);
                }
            }

            $item->image_urls = $itemImageUrls;

            return $item;
        });

        // return $response;
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
