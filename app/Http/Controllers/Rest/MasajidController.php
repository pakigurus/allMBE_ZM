<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Google\GoogleApi;
use App\Facades\Utilities\Utilities;
use App\Model\Location;
use App\Model\Masajid;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MasajidController extends Controller
{

    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() :JsonResponse
    {
        $user = User::with(['masajid' => function ($query) {
           $query->where('status' , 1);
        }])->find(Auth::id());

        return response()->json($user);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) :JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'google_masajid_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }

       DB::transaction(function () use ($request){
            $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();
            if (!$masajid){
                $masajid = new Masajid();
                $masajid->google_masajid_id = $request->google_masajid_id;
                $masajid->name = $request->name;
                $masajid->address = $request->address;
                $masajid->lat = $request->lat;
                $masajid->long = $request->long;
                $masajid->non_masajid = $request->non_masajid ?? 0;
                $masajid->save();
            }
            if (!$request->non_masajid){
                if (Auth::guard('api')->check()) {
                    $user = Auth::guard('api')->user();
                    $masajid->user()->syncWithoutDetaching($user->id);
                }
            }
        })
       ;
        return response()->json(['message' => 'Masajid Add Successfully'], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function GoogleShow(Request $request, $id) :JsonResponse
    {
        $with = $request->with;
        $masjid = Masajid::with($with)->whereGoogleMasajidId($id)->first();
        if (!$masjid || count($masjid->$with) < 1)
        {
            return response()->json(['error' => 'data not found'], 404);
        }
        return response()->json($masjid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : JsonResponse
    {
        Auth::user()->masajid()->detach($id);

        return response()->json(Auth::user()->load('masajid'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function nearByMasajids(Request $request) {
        $location = Location::where(['latitude' => $request->lat , 'longitude' => $request->long])->exists();
        if (!$location) {
            $location = new Location();
            $location->latitude = $request->lat;
            $location->longitude = $request->long;
            //uncomment after confirmation from QA
//            $results = $this->getMasajidWithGoogle($request);
            $location->save();
        }
//        else {
//            $results = $this->getMasajidWithAllmasajidDB($request);
//        }
        $results = $this->getMasajidWithGoogle($request);

        return response()->json($results);
    }


    public function nearByNonMasajids(Request $request) {
        $google = new GoogleApi();
        $rawResponse = $google->nonMasajidSearch($request);
        $results = data_get($rawResponse, 'results');
        $next_page_token = data_get($rawResponse, 'next_page_token');
        return response()->json(['data' => $results ,'next_page_token' => $next_page_token]);
    }

    protected function getMasajidWithGoogle($request) {
        $google = new GoogleApi();
        $rawResponse = $google->masajidSearch($request);
        $results = data_get($rawResponse, 'results');
        $i = [];
        foreach ($results as $key => $data) {
            $masajid = Masajid::where('google_masajid_id', 'LIKE' , "%$data->place_id%")->first();
            if (!$masajid) {
                $masajid = new Masajid();
                $masajid->google_masajid_id = $data->place_id;
                $masajid->name = $data->name;
                $masajid->address = $data->vicinity;
                $masajid->lat = $data->geometry->location->lat;
                $masajid->long = $data->geometry->location->lng;
                $masajid->save();
            }
            if ($masajid->status == 0) {
                $i[] = $data->place_id;
                unset($results[$key]);
            }
            //get distance
            $data->distance = $this->distance($request->lat , $request->long , $data->geometry->location->lat, $data->geometry->location->lng  , $request->unit);
            $data->distance = number_format($data->distance , 1);
            $data->unit = $request->unit;
            $data->feed_need = $masajid->feed_need;
        }
        $results = collect($results)->whereNotIn('place_id' , $i)->unique(function($result){
            return strtolower($result->name) . strtolower($result->vicinity);
        })->sortBy('distance')->values()->all();

        return $results;
    }

    protected function getMasajidWithAllmasajidDB($request) {
        $masajids = Masajid::where(['status' => 1])->get();
        foreach ($masajids as $key => $masajid) {
            $masajid->unit = $request->unit;
            if ($masajid->distance >= $request->distance) {
                unset($masajids[$key]);
            }
        }
        return $masajids->values();
    }
}
