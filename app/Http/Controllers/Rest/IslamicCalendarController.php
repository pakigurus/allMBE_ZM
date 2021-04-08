<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Utilities\Utilities;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IslamicCalendarController extends Controller
{

    use Utilities;

    private $baseUrl = 'http://api.aladhan.com/v1';
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 50,
        ]);
    }

    public function getIslamicMonthCalendar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|digits:4|numeric',
            'setting' => 'numeric|nullable'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 401);
        }
        $url = "https://api.aladhan.com/v1/gToHCalendar/{$request->month}/{$request->year}";
        $monthData = ($this->curlRequest($url))->data;

        //add today in month
        $collection = collect($monthData)->values();
        $collection = $collection->map(function ($item) use($request){
            // plus and minus days in islamic calendar
                $request->setting < 0 ? $month = 5 : $month = 4;
                $day = Carbon::createFromDate(2021 ,$month, $item->hijri->day );
                $item->hijri->day = $day->addDays($request->setting)->format('d');
            // add toDate in collection
                if ($item->gregorian->date === Carbon::now()->format('d-m-Y')) {
                    $item->gregorian->toDate = true;
                } else {
                    $item->gregorian->toDate = false;
                }
               return $item;
        });

        //get current islamic months array and year
        $monthName['en'] = $collection->pluck('hijri.month.en')->unique()->values();
        $monthName['ar'] = $collection->pluck('hijri.month.ar')->unique()->values();
        $monthName['year'] = $collection->pluck('hijri.year')->unique()->values();

        //get holidays from current month
        $holidays = [];
        foreach ($collection as $task) {
            if (!empty($task->hijri->holidays)) {
                $holidays[] = $task;
            }
        }

        return response()->json(['months' => $monthName, 'holidays' => $holidays, 'data' => $collection]);
    }

    public function islamicHolidaysAddingFile()
    {

        $holidays = [];
        for ($i = 1; $i <= 12; $i++) {
            $url = "https://api.aladhan.com/v1/gToHCalendar/{$i}/2021";
            $monthData = ($this->curlRequest($url))->data;
            $collection = collect($monthData)->values();

            //get holidays from current month
            foreach ($collection as $task) {
                if (!empty($task->hijri->holidays)) {
                    $holidays[] = $task;
                }
            }
        }

        Storage::disk('public')->put('movies.json', json_encode($holidays));

        $file = Storage::disk('public')->get('movies.json');
        $json_file = json_decode($file, true);
        return response()->json($json_file);
    }

    public function islamicHolidays(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'setting' => 'numeric|nullable'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 401);
        }
        $file = Storage::disk('public')->get('movies.json');
        $json_file = json_decode($file, true);

        //making array into objects
        $obj = json_decode(json_encode($json_file));

        $collection = collect($obj)->map(function ($item) use ($request){
            // plus and minus days in islamic calendar
            $request->setting < 0 ? $month = 5 : $month = 4;
            $day = Carbon::createFromDate(2021 ,$month, $item->hijri->day );
            $item->hijri->day = $day->addDays($request->setting)->format('d');

            $holidayDate = Carbon::parse($item->gregorian->date);
            $currentDate = Carbon::now();

            $differenceInDate = $holidayDate->diffInDays($currentDate);
            $item->diffInDays = $differenceInDate;
            $holidayDate < $currentDate ? $item->status = "PAST" : $item->status = "FUTURE";
            return $item;
        });

        return response()->json($collection);
    }

    public function prayerTimingOnDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|digits:4|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'date' => 'required|numeric|min:1|max:31'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 401);
        }

        $response = $this->client->get('/calendar', [
            RequestOptions::QUERY => [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'method' => 2,
                'year' => $request->year,
                'month' => $request->month,
            ]
        ]);

        //get raw data
        $data = json_decode($response->getBody()->getContents())->data;

        //date
        $date = Carbon::create($request->year,$request->month , $request->date)->format('d-m-Y');
        $collection = collect($data)->filter(function($item) use ($date)
        { if($item->date->gregorian->date === $date) {
                return $item;
            }
        })->values()->first();
        return response()->json($collection);
    }

}
