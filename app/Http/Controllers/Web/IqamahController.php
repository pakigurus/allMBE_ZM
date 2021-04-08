<?php

namespace App\Http\Controllers\Web;

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

class IqamahController extends Controller
{
    public function index(){
        $masajids=Masajid::where('non_masajid' , 0)->select('google_masajid_id' , 'name')->get();

        return view('pages.Iqamah.allIqamah',compact('masajids'));
    }

    public function create() {

        $masajids=Masajid::where('non_masajid' , 0)->select('google_masajid_id' , 'name')->get();
        return view('pages.Iqamah.createIqamah',compact('masajids'));
    }

    public function store(Request $request) {
        $request->timezone = null;


         $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();

            if ($request->fajr_time && $request->fajr_end_date && $request->fajr_start_date) {
                    $dateRange = $this->date_range(Carbon::parse( $request->fajr_start_date), Carbon::parse($request->fajr_end_date));
                    foreach ($dateRange as $date) {
                        $asr = new FajrIqamah();
                        $asr->masajids_id = $masajid->id;
                        $asr->time = Carbon::parse($request->fajr_time, $request->timezone)->setTimezone('UTC')->toTimeString();
                        $asr->to_date =  $request->fajr_end_date;
                        $asr->end_date =  $request->fajr_start_date;
                        $asr->date = $date;
                        $asr->status = 1;
                        $asr->save();
                    }
            }

           if ($request->duhr_time  && $request->duhr_start_date && $request->duhr_end_date) {
                   $dateRange = $this->date_range(Carbon::parse( $request->duhr_start_date), Carbon::parse($request->duhr_end_date));
                   foreach ($dateRange as $date) {
                       $asr = new DuhrIqamah();
                       $asr->masajids_id = $masajid->id;
                       $asr->time = Carbon::parse($request->duhr_time, $request->timezone)->setTimezone('UTC')->toTimeString();
                       $asr->to_date = $request->duhr_start_date;
                       $asr->end_date = $request->duhr_end_date;
                       $asr->date = $date;
                       $asr->status = 1;
                       $asr->save();
                   }
           }


           if ($request->asr_time && $request->asr_start_date && $request->asr_end_date) {

                   $dateRange = $this->date_range(Carbon::parse($request->asr_start_date), Carbon::parse($request->asr_end_date));
                   foreach ($dateRange as $date){
                       $asr = new AsrIqamah();
                       $asr->masajids_id = $masajid->id;
                       $asr->time = Carbon::parse($request->asr_time , $request->timezone)->setTimezone('UTC')->toTimeString();
                       $asr->date = $date;
                       $asr->to_date = $request->asr_start_date;
                       $asr->end_date =$request->asr_end_date;
                       $asr->status = 1;
                       $asr->save();
                   }

           }

           if ($request->isha_time && $request->isha_start_date && $request->isha_end_date) {

                   $dateRange = $this->date_range(Carbon::parse($request->isha_start_date), Carbon::parse( $request->isha_end_date));
                   foreach ($dateRange as $date) {
                       $ishaa = new IshaIqamah();
                       $ishaa->masajids_id = $masajid->id;
                       $ishaa->time = Carbon::parse($request->isha_time, $request->timezone)->setTimezone('UTC')->toTimeString();
                       $ishaa->to_date = $request->isha_start_date ;
                       $ishaa->end_date = $request->isha_end_date;
                       $ishaa->date = $date;
                       $ishaa->status = 1;
                       $ishaa->save();

               }

           }



           if ($request->jumah_type && $request->jumah_time) {

                   $ishaa = new JumahIqamah();
                   $ishaa->masajids_id = $masajid->id;
                   $ishaa->time = Carbon::parse($request->jumah_time, $request->timezone)->setTimezone('UTC')->toTimeString();
                   $ishaa->type = $request->jumah_type;
                   $ishaa->to_date = Carbon::create(2010 , 1,1)->toDateString();
                   $ishaa->end_date = Carbon::create(2030 , 1,1)->toDateString();
                   $ishaa->save();
               }


           if ($request->maghrib_time) {
               $maghribs = new MaghribIqamah();
               $maghribs->masajids_id = $masajid->id;
               $maghribs->minutes = $request->maghrib_time;
               $maghribs->status = 1;
               $maghribs->save();
           }

           return back()->with('success' ,'Save Successfully');

    }


    public function Masajid(Request $request) {

        $iqamah = Masajid::with(['fajr', 'duhr', 'asr' ,'maghrib', 'isha'])->whereGoogleMasajidId($request->google_masajid_id)->first();


        $masajids=Masajid::where('non_masajid' , 0)->select('google_masajid_id' , 'name')->get();
        return view('pages.Iqamah.allIqamah',compact('masajids', 'iqamah'));
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

}
