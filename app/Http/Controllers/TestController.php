<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\Item;
use App\Models\User;
use App\Traits\FormatLines;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Models\OracleCustomer;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    use FormatLines;
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function test()
    {


        $qoute = Inspiring::quote();
        dd($qoute);
        // send test email here

        // Send a test email using PHP's mail function
        // $to = 'itstaff2@times.com';
        // $subject = 'Test Email';
        // $message = 'This is a test email.';
        // $headers = 'From: itstaff2@times.com' . "\r\n" .
        //     'Reply-To: itstaff2@times.com' . "\r\n" .
        //     'X-Mailer: PHP/' . phpversion();

        // if (mail($to, $subject, $message, $headers)) {
        //     return 'Test email sent successfully!';
        // } else {
        //     return 'Failed to send test email.';
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

                // echo "<img src='$src' alt=''>";
                // $headers = @get_headers($src);

                // if ($headers && strpos($headers[0], '200') !== false) {
                //     echo 'has image';
                //     array_push($itemImageUrls, $src);
                // }

                try {
                    if ($this->remoteFileExists($src)) {
                        echo '<h1>has image</h1>';
                    } else {
                        echo '<h1>No image</h1>';
                    }
                } catch (\Exception $e) {
                    echo '<h1>Error: ' . $e . '</h1>';
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
        $response = curl_exec($ch);

        // Check for curl errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Curl error: $error_msg");
        }

        // Check HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close curl session
        curl_close($ch);

        // Debugging information
        echo '<pre>';
        echo 'URL: ' . $url . "\n";
        echo 'HTTP Code: ' . $httpCode . "\n";
        echo 'Response: ' . $response . "\n";
        echo '</pre>';

        // Return true if the HTTP response code is 200 (OK)
        return $httpCode === 200;
    }
}
