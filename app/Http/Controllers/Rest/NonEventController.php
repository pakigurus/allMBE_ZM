<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Google\GoogleApi;
use App\Facades\Utilities\Utilities;
use App\Http\Controllers\Controller;
use App\Model\Event;
use App\Model\Masajid;
use App\Model\NonAnnouncement;
use App\Model\NonEvent;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Psy\Util\Json;

class NonEventController extends Controller
{
    use Utilities;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }

        $data = (object)['lat' => $request->latitude , 'long' => $request->longitude];
        $googleApi = new GoogleApi();
        $rawResponse = $googleApi->masajidPlaceCountry($data);
        $results = data_get($rawResponse, 'results');

        foreach ($results[0]->address_components as $address) {
            if (in_array("administrative_area_level_2", $address->types)) {
                $data->city = $address->long_name;
            } else if(in_array("country", $address->types)){
                $data->country = $address->long_name;
            } else if(in_array("administrative_area_level_1", $address->types)){
                $data->state = $address->long_name;
            }
        }

        abort_if(!$data->city ,404, 'No city found against your current location');

        $rawResponse2 = $googleApi->getCityData($data->city);
        $results2 = data_get($rawResponse2, 'results');

        $data->lat = $results2[0]->geometry->location->lat ;
        $data->lat = $results2[0]->geometry->location->lat ;
        $data->city_id = $results2[0]->place_id ;

        $non_event = NonEvent::where(['city_id' => $data->city_id])->get();

        return \response()->json($non_event);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'city_name' => 'required',
            'place_id' => 'required',
            'place_name' => 'required',
            'place_address' => 'required',
            'city_latitude' => 'required',
            'city_longitude' => 'required',
            'place_latitude' => 'required',
            'place_longitude' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'time' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'link' => 'nullable',
            'message' => 'nullable',
            'address' => 'required',
            'image'     =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        $image = $request->file('image');
        DB::transaction(function () use($request, $image){
            //add event
            $event = new NonEvent();
            if ($request->image){
                //add image
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/events/');
                $resize_image = Image::make($image->getRealPath());
                $resize_image->resize(400, 400, function($constraint){
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $image_name);
                $event->image = $image_name;
            }
            $event->city_id = $request->city_id;
            $event->city_name = $request->city_name;
            $event->city_latitude = $request->city_latitude;
            $event->city_longitude = $request->city_longitude;
            $event->place_id = $request->place_id;
            $event->place_name = $request->place_name;
            $event->place_latitude = $request->place_latitude;
            $event->place_longitude = $request->place_longitude;
            $event->place_address = $request->place_address;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = Carbon::parse($request->date)->toDateString();
            $event->time = Carbon::parse($request->time)->toTimeString();
            $event->contact = $request->contact;
            $event->email = $request->email;
            $event->link = $request->link;
            $event->status = false;
            $event->message = $request->message;
            $event->address = $request->address;
            $event->save();

            //event linked to user if user is active
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $event->user_id = $user->id;
            }
            if ($event->save()) {
                $this->sendVerifyEmail('Non Event', $event);
            }
            $event->save();
        });

        return response()->json(['message' => 'Event Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\NonEvent  $nonEvent
     * @return \Illuminate\Http\Response
     */
    public function show(NonEvent $nonEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\NonEvent  $nonEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(NonEvent $nonEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\NonEvent  $nonEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) : JsonResponse
    {
        NonEvent::where('id' , $id)->update($request->all());
        return \response()->json(['message' => 'Non Masajid Evenet has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\NonEvent  $nonEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : JsonResponse
    {
        $non_event = NonEvent::query()->where('id' , $id)->delete();
        return \response()->json(['message'=>'Non Masajid event has been deleted successfully']);
    }


    public function userNonEvents() {
        $user = Auth::guard('api')->user();
        $nonEvents = NonEvent::where('user_id', $user->id)->get();

        abort_if(empty($nonEvents) , 404 , 'not found');
        return response()->json($nonEvents);
    }
}
