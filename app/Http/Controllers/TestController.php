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

        // $url = "http://113.1.1.190/phase7/pictures/003438.jpg";

        // echo "<img src='$url' alt=''>";
        // $headers = @get_headers($url);
        // echo $headers;
        // if ($headers && strpos($headers[0], '200') !== false) {
        //     echo '<h1>has image</h1>';
        // } else {
        //     echo '<h1>No image</h1>';
        // }
    }

    public function getItemsAll()
    {
        $query = Item::query();


        $query->where('inventory_item_id', 4441);
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

                echo $src . " : <br>";

                echo '<img src="$src" alt="">';
                // $headers = @get_headers($src);

                // if ($headers && strpos($headers[0], '200') !== false) {
                //     echo 'has image';
                //     array_push($itemImageUrls, $src);
                // }

                // if ($this->remoteFileExists($src)) {
                //     echo 'has image';
                //     array_push($itemImageUrls, $src);
                // }
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
