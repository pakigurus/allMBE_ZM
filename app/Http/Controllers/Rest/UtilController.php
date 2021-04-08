<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Utilities\Utilities;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UtilController extends Controller
{
    use Utilities;

    public function getWFDays(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'setting' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }

        $param = $request->setting;
        $date = Carbon::now()->addDays($param)->format('d-m-Y');
        $url = "http://api.aladhan.com/v1/gToH?date=".$date;

        //get TODAY date
        $todayDates = $this->curlRequest($url);

        $hijriMonth = $todayDates->data->hijri->month->number;
        $hijriYear = $todayDates->data->hijri->year;

        // get WFD
        $nextUrl = "http://api.aladhan.com/v1/hToGCalendar/".$hijriMonth."/".$hijriYear;

        //get full month result
        $output = $this->curlRequest($nextUrl);

        $dates = [13,14,15];

        if ($param) {
            foreach ($dates as $date)
            {
                $newDates[] = $date+$param;
            }
        } else {
            $newDates = $dates;
        }

        foreach ($output->data as $calender)
        {
            foreach ($newDates as $date)
            {
                if ($calender->hijri->day == $date)
                {
                    $newArr[] = $calender;
                }
            }
        }

        //get current day through HCScrapping
        $day = $this->scrapeDateHC();

        // if any issue in HC, then we will get current date through allMasajid.com
        if (!isset($day)) {
            $day = ($this->scrapeDateAllMasajid()->data->Day)+$param;
        }

        $day = $day + $param;
        if ($day <= 0 or $day > 30){
            $todayDates->data->hijri->day += 0;
        } else {
            $todayDates->data->hijri->day = $day;
        }

        return response()->json(['wfd' => $newArr, 'today' => $todayDates->data]);
    }


    //scrap the date
    public function scrapeDateHC() {
        $url = file_get_contents('https://hilalcommittee.org/');
        header('Content-Type: text/html; charset=utf-8');
        // create new DOMDocument
        $document = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $document->preserveWhiteSpace = false;

        $document->loadHTML($url);
        libxml_use_internal_errors($internalErrors);
        $xpath = new DOMXPath($document);
        $query = "//div[@class='td-fix-index']";
        $queryIframe = "//div[@class='hangingdate']/span[@class='IDate']";
        $entries = $xpath->query($queryIframe);

        $title = [];
        foreach ($entries as $entry) {
            $value = $entry->nodeValue;
            array_push($title , $value);
        }

        $int = (int) filter_var( $title[0], FILTER_SANITIZE_NUMBER_INT);
        return $int;
    }



    //get data from Allmasajid
    public function scrapeDateAllMasajid() {
        $url = 'https://www.allmasajid.com/wp-json/islamicdate/all';
       return $this->curlRequest($url);
    }
}
