<?php


namespace App\Facades\Utilities;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

trait Utilities
{

    //find distance
    function distance($lat1, $lon1, $lat2, $lon2, $unit = "M") {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return $miles * 1.609344;
            } else if ($unit == "N") {
                return $miles * 0.8684;
            } else {
                return $miles;
            }
        }
    }


    //change CSV file into array as respect to first column
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }

    function curlRequest($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output);
    }

    function generateSurrogateId($country, $city, $id) {
        $country = strtoupper($country);
        $city = strtoupper($city);
        if (Str::contains($country, ' ')){
            $words = explode(" ", $country);
            $countryID = "";
            foreach ($words as $w) {
                $countryID .= $w[0];
            }
        } else {
            $countryID = substr($country, 0, 3);
        }
        if (Str::contains($city, ' ')){
            $words = explode(" ", $city);
            $cityID = "";
            foreach ($words as $w) {
                $cityID .= $w[0];
            }
        } else {
            $cityID = substr($city, 0, 3);
        }

        return "{$countryID}-{$cityID}-{$id}";
    }


    public function sendVerifyEmail($moduleName , $model) {
        $name = Auth::guard('api')->user()->full_name ?? "User";
        $email = Auth::guard('api')->user()->email ?? $model->email;

        //data send to next email page
        $data = array('name'=> $name, 'model'=> $model, 'moduleName' => $moduleName ,'moduleURLName' => strtolower($moduleName));

        Mail::send('ModuleConfirmationEmail', $data, function($message) use($name , $email, $moduleName){
            $message->to($email, $name)
                ->subject("{$moduleName} Request Verification");
            $message->from('web.allmasajid@net',"{$moduleName} Request Verification");
        });
    }

    public function userVerify($model) {
        $name = $model->full_name ?? "User";
        $email = $model->email;

        //data send to next email page
        $data = array('name'=> $name, 'model'=> $model);

        Mail::send('UserConfirmationEmail', $data, function($message) use($name , $email){
            $message->to($email, $name)
                ->subject("allMasajid User Verification");
            $message->from('web.allmasajid@net',"allMasajid User Verification");
        });
    }

}
