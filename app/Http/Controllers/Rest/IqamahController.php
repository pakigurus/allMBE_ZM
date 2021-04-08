<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Google\GoogleApi;
use App\Facades\Utilities\Utilities;
use App\Model\AsrIqamah;
use App\Model\DuhrIqamah;
use App\Model\FajrIqamah;
use App\Model\IshaIqamah;
use App\Model\JumahIqamah;
use App\Model\MaghribIqamah;
use App\Model\Masajid;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IqamahController extends Controller
{

    use Utilities;

    public function getIqamah(Request $request) {

        $request->timezone = null;

        $google = new GoogleApi();
        $rawResponse = $google->masajidSearch($request);

        $results = data_get($rawResponse, 'results');

        $i = [];
//        DB::transaction(function () use ($results, $request, $google){
            foreach ($results as $key => $data) {
                $masajid = Masajid::with(['fajr', 'duhr', 'asr' ,'maghrib', 'isha'])->whereGoogleMasajidId($data->place_id)->first();
                if (!$masajid){
                    $masajid = new Masajid();
                    $masajid->google_masajid_id = $data->place_id;
                    $masajid->name = $data->name;
                    $masajid->address = $data->vicinity;
                    $masajid->lat = $data->geometry->location->lat;
                    $masajid->long = $data->geometry->location->lng;
                    $masajid->save();
                }
                //get distance
                $data->distance = $this->distance($request->lat , $request->long , $data->geometry->location->lat, $data->geometry->location->lng  , $request->unit);
                $data->distance = number_format($data->distance , 1);
                $data->unit = $request->unit;

                //distance get from google map api
                $timeDuration = $google->masajidDistanceTime($request, $data->place_id );
                $data->timeDuration = $timeDuration->routes[0]->legs[0]->duration;

                //get Iqamah
                $data->fajr = FajrIqamah::where("masajids_id", $masajid->id)
                    ->where('to_date', '<=' , Carbon::now()->setTimezone($request->timezone)->toDateString())
                    ->where('end_date', '>=', Carbon::now()->setTimezone($request->timezone)->toDateString())->latest()->first();
                $data->duhr = DuhrIqamah::where("masajids_id", $masajid->id)
                    ->where('to_date', '<=' , Carbon::now()->setTimezone($request->timezone)->toDateString())
                    ->where('end_date', '>=', Carbon::now()->setTimezone($request->timezone)->toDateString())->latest()->first();
                $data->asr = AsrIqamah::where("masajids_id", $masajid->id)
                    ->where('to_date', '<=' , Carbon::now()->setTimezone($request->timezone)->toDateString())
                    ->where('end_date', '>=', Carbon::now()->setTimezone($request->timezone)->toDateString())->latest()->first();
                $data->isha = IshaIqamah::where("masajids_id", $masajid->id)
                    ->where('to_date', '<=' , Carbon::now()->setTimezone($request->timezone)->toDateString())
                    ->where('end_date', '>=', Carbon::now()->setTimezone($request->timezone)->toDateString())->latest()->first();
                $data->jumah = JumahIqamah::where("masajids_id", $masajid->id)
                    ->where('to_date', '<=' , Carbon::now()->setTimezone($request->timezone)->toDateString())
                    ->where('end_date', '>=', Carbon::now()->setTimezone($request->timezone)->toDateString())->select('type', 'time')->distinct()->orderBy('type')->get();
                $data->maghrib = MaghribIqamah::where("masajids_id", $masajid->id)
                    ->latest()->first();

                //get today date by Timezone
                $today = Carbon::today($request->timezone)->toDateString();
                if ($data->fajr) {

                    $data->fajr->diff_time_number = Carbon::createFromFormat('Y-m-d H:i:s',$today.' '.$data->fajr->time , 'UTC')->setTimezone($request->timezone)->diffInMinutes($request->current_time);
                    $data->fajr->diff_time = gmdate('i:s', $data->fajr->diff_time_number);

                    $data->fajr->time = Carbon::parse($data->fajr->time)->setTimezone($request->timezone)->format('g:i A');

                }

                if ($data->duhr) {
                    $data->duhr->diff_time_number = Carbon::createFromFormat('Y-m-d H:i:s',$today.' '.$data->duhr->time , 'UTC')->setTimezone($request->timezone)->diffInMinutes($request->current_time);
                    $data->duhr->diff_time = gmdate('i:s', $data->duhr->diff_time_number);

                    $data->duhr->time = Carbon::parse($data->duhr->time)->setTimezone($request->timezone)->format('g:i A');

                }

                if ($data->asr) {
                    $data->asr->diff_time_number = Carbon::createFromFormat('Y-m-d H:i:s',$today.' '.$data->asr->time , 'UTC')->setTimezone($request->timezone)->diffInMinutes($request->current_time);
                    $data->asr->diff_time = gmdate('i:s', $data->asr->diff_time_number);

                    $data->asr->time = Carbon::parse($data->asr->time)->setTimezone($request->timezone)->format('g:i A');
                }

                if ($data->isha) {
                    $data->isha->diff_time_number = Carbon::createFromFormat('Y-m-d H:i:s',$today.' '.$data->isha->time , 'UTC')->setTimezone($request->timezone)->diffInMinutes($request->current_time);
                    $data->isha->diff_time = gmdate('i:s', $data->isha->diff_time_number);

                    $data->isha->time = Carbon::parse($data->isha->time)->setTimezone($request->timezone)->format('g:i A');
                }

                if($data->maghrib) {
                    $data->maghrib->time = $data->maghrib->minutes;
                    $data->maghrib->diff_time_number = Carbon::parse($request->maghrib_time)->diffInMinutes($request->current_time);
                    $data->maghrib->diff_time_number =  $data->maghrib->diff_time_number+$data->maghrib->time;
                    $data->maghrib->diff_time = gmdate('i:s', $data->maghrib->diff_time_number);
                }

                foreach ($data->jumah as $jumah) {
                    $jumah->diff_time_number = Carbon::createFromFormat('Y-m-d H:i:s',$today.' '.$jumah->time , 'UTC')->setTimezone($request->timezone)->diffInMinutes($request->current_time);
                    $jumah->diff_time = gmdate('i:s', $jumah->diff_time_number);

                    $jumah->time = Carbon::parse($jumah->time)->setTimezone($request->timezone)->format('g:i A');
                }

                $today = Carbon::today()->setTimezone($request->timezone);
                if($today->dayOfWeek == Carbon::FRIDAY) {
                    $data->is_friday = true;
                } else {
                    $data->is_friday = false;
                }
                if ($masajid->status == 0) {
                    $i[] = $data->place_id;
                    unset($results[$key]);
                }
            }
//        });

        $results = collect($results)->whereNotIn('place_id' , $i)->unique(function($result){
            return strtolower($result->name) . strtolower($result->vicinity);
        })->sortBy('distance')->values()->all();
        return response()->json($results);
    }


    public function addIqamah(Request $request){
        $request->timezone = null;
       $masajid =  DB::transaction(function () use ($request){
            $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();

            if ($request->fajr) {
                $fajr =  json_decode($request->fajr);
                foreach ($fajr as $data)
                {
                    $data = json_decode($data);
                    $dateRange = $this->date_range(Carbon::parse($data->toDate), Carbon::parse($data->endDate));
                    foreach ($dateRange as $date) {
                        $asr = new FajrIqamah();
                        $asr->masajids_id = $masajid->id;
                        $asr->time = Carbon::parse($data->time, $request->timezone)->setTimezone('UTC')->toTimeString();
                        $asr->to_date = $data->toDate;
                        $asr->end_date = $data->endDate;
                        $asr->date = $date;
                        $asr->save();
                    }

                }
            }

           if ($request->duhr) {
               $duhr =  json_decode($request->duhr);
               foreach ($duhr as $data)
               {
                   $data = json_decode($data);
                   $dateRange = $this->date_range(Carbon::parse($data->toDate), Carbon::parse($data->endDate));
                    foreach ($dateRange as $date) {
                        $asr = new DuhrIqamah();
                        $asr->masajids_id = $masajid->id;
                        $asr->time = Carbon::parse($data->time, $request->timezone)->setTimezone('UTC')->toTimeString();
                        $asr->to_date = $data->toDate;
                        $asr->end_date = $data->endDate;
                        $asr->date = $date;
                        $asr->save();
                    }

               }
           }


           if ($request->asr) {
               $asr =  json_decode($request->asr);
               foreach ($asr as $data)
               {
                   $data = json_decode($data);
                   $dateRange = $this->date_range(Carbon::parse($data->toDate), Carbon::parse($data->endDate));
                   foreach ($dateRange as $date){
                       $asr = new AsrIqamah();
                       $asr->masajids_id = $masajid->id;
                       $asr->time = Carbon::parse($data->time, $request->timezone)->setTimezone('UTC')->toTimeString();
                       $asr->date = $date;
                       $asr->to_date = $data->toDate;
                       $asr->end_date = $data->endDate;
                       $asr->save();
                   }
               }
           }

           if ($request->isha) {
               $isha =  json_decode($request->isha);
               foreach ($isha as $data)
               {
                   $data = json_decode($data);
                   $dateRange = $this->date_range(Carbon::parse($data->toDate), Carbon::parse($data->endDate));
                   foreach ($dateRange as $date) {
                       $ishaa = new IshaIqamah();
                       $ishaa->masajids_id = $masajid->id;
                       $ishaa->time = Carbon::parse($data->time, $request->timezone)->setTimezone('UTC')->toTimeString();
                       $ishaa->to_date = $data->toDate;
                       $ishaa->end_date = $data->endDate;
                       $ishaa->date = $date;
                       $ishaa->save();
                   }

               }

           }



           if ($request->jumah) {
               $jumah =  json_decode($request->jumah);
               foreach ($jumah as $data)
               {

                   $data = json_decode($data);

                   $ishaa = new JumahIqamah();
                   $ishaa->masajids_id = $masajid->id;
                   $ishaa->time = Carbon::parse($data->time, $request->timezone)->setTimezone('UTC')->toTimeString();
                   $ishaa->type = $data->type;
                   $ishaa->to_date = Carbon::create(2010 , 1,1)->toDateString();
                   $ishaa->end_date = Carbon::create(2030 , 1,1)->toDateString();
                   $ishaa->save();
               }
           }

           if ($request->maghrib) {
                   $maghribs = new MaghribIqamah();
                    $maghribs->masajids_id = $masajid->id;
                    $maghribs->minutes = $request->maghrib;
                    $maghribs->save();
           }
            return $masajid;
        });

        return $masajid;

    }

    function date_range(Carbon $from, Carbon $to, $inclusive = true)
    {
        if ($from->gt($to)) {
            return null;
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();

        // Include the end date in the range
        if ($inclusive) {
            $to->addDay();
        }

        $step = CarbonInterval::day();
        $period = new DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = new Carbon($day);
        }

        return ! empty($range) ? $range : null;
    }

    public function singleMasajidIqamah(Request $request) {

        $request->timezone = null;

        $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();

        //get dates array of current month
        $dates = [];
            for ($i = 0 ; $i < Carbon::now()->daysInMonth ; $i++) {
                $dates[] = Carbon::now()->startOfMonth()->addDays($i)->toDateString();
            }

        $jsonArray = [];
        foreach ($dates as $date) {
            $fajr = FajrIqamah::where('masajids_id', $masajid->id)->where('date' , $date)->latest()->first();
            ($fajr)  ? $fajr->time = Carbon::parse($fajr->time)->setTimezone($request->timezone)->format('g:i A') : "";

            $fajr ? $jsonArray['fajr'][] = $fajr : $jsonArray['fajr'][] = null;

            $duhr = DuhrIqamah::where('masajids_id', $masajid->id)->where('date', $date)->latest()->first();
            ($duhr)  ?  $duhr->time = Carbon::parse($duhr->time)->setTimezone($request->timezone)->format('g:i A') : "";

            $duhr ? $jsonArray['duhr'][] = $duhr : $jsonArray['duhr'][] = null;

            $asr = AsrIqamah::where('masajids_id', $masajid->id)->where('date', $date)->latest()->first();
            ($asr)  ?  $asr->time = Carbon::parse($asr->time)->setTimezone($request->timezone)->format('g:i A') : "";
            $asr ? $jsonArray['asr'][] = $asr : $jsonArray['asr'][] = null;

            $isha = IshaIqamah::where('masajids_id', $masajid->id)->where('date', $date)->latest()->first();
            ($isha)  ?  $isha->time = Carbon::parse($isha->time)->setTimezone($request->timezone)->format('g:i A') : "";

            $isha ? $jsonArray['isha'][] = $isha : $jsonArray['isha'][] = null;
        }

        $jumah = JumahIqamah::where("masajids_id", $masajid->id)
            ->where('to_date', '<=' , Carbon::now()->setTimezone($request->timezone)->toDateString())
            ->where('end_date', '>=', Carbon::now()->setTimezone($request->timezone)->toDateString())->select('type', 'time')->distinct()->orderBy('type')->get();
        foreach ($jumah as $jummah) {
             ($jummah)  ?  $jummah->time = Carbon::parse($jummah->time)->setTimezone($request->timezone)->format('g:i A') : "";
        }
        $jumah ? $jsonArray['jummah'] = $jumah : $jsonArray['jumah'] = null;

        $maghrib = MaghribIqamah::where("masajids_id", $masajid->id)
            ->latest()->first();
        $maghrib ? $jsonArray['maghrib'] = $maghrib : $jsonArray['maghrib'] = null;

        $data = [];
        for ($i = 0; $i < count($dates); $i++) {
            $data[] = [
                'date' => $dates[$i],
                'fajr' => $jsonArray['fajr'][$i] ?? null,
                'duhr' => $jsonArray['duhr'][$i] ?? null,
                'asr' => $jsonArray['asr'][$i] ?? null,
                'maghrib' => $jsonArray['maghrib'] ?? null,
                'isha' => $jsonArray['isha'][$i] ?? null,
            ];
        }

        return response()->json(['data' => $data , 'jummah' => $jsonArray['jummah']]);

    }



}
