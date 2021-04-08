<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Utilities\Utilities;
use App\Model\Event;
use App\Model\Masajid;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use function foo\func;

class EventController extends Controller
{
    use Utilities;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'google_masajid_id' => 'required',
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
        $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();
        DB::transaction(function () use($masajid, $request, $image){
            //add event
            $event = new Event();
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
            $event->masajids_id = $masajid->id;
            $event->save();

            //event linked to user if user is active
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $event->user_id = $user->id;
            }
            if ($event->save()) {
                $this->sendVerifyEmail('Event', $event);
            }
            $event->save();
        });

        return response()->json(['message' => 'Event Created Successfully']);
    }

    public function index()
    {
        $events = Event::with('masajid')->get();
        return $events;
    }

    public function show($id)
    {
        $event = Event::with('masajid')->find($id);
        if (!$event)
        {
            return response()->json(['error'=> 'no record found'], 404);
        }
        return $event;
    }

    public function userEvents()
    {
        $user = User::with('event')->find(Auth::id());
        $eve = [];
        foreach ($user->event as $data)
        {
            if ($data->created_at < Carbon::now()->subDays(2))
            {
                $data->reschedule = true;
            }else{
                $data->reschedule = false;
            }
            $eve[] = $data;
        }
        $user->event = $eve;
        return $user;
    }
    public function userSingleEvents($id)
    {
       $user = Auth::user();
       $event = Auth::user()->event()->where(['id'=>$id])->first();
            if ($event->created_at < Carbon::now()->subDays(2))
            {
                $event->reschedule = true;
            }else{
                $event->reschedule = false;
            }
       return $event;
    }

    public function destroy($id)
    {
        Auth::user()->event()->whereId($id)->delete();
        return response()->json(['message' => 'Event deleted Successfully']);
    }

    public function RescheduleEvent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }

        $exists = Auth::user()->event()->where(['events_id'=>$id])->exists();
        if (!$exists)
        {
            return response()->json(['error'=> 'Event is not found against this user'], 403);
        }
        DB::transaction(function () use($request, $id){
            $event = Event::find($id);
            $event->date = Carbon::parse($request->date)->toDateString();
            $event->time = Carbon::parse($request->time)->toTimeString();
            $event->description = $request->description;
            $event->save();
        });
        return response()->json(['message'=> 'Event Successfully Updated'], 200);
    }


    public function addToFav(Event $id)
    {
        $user = Auth::user();

        $user->favouriteEvents()->syncWithoutDetaching($id);
        foreach ($user->favouriteEvents as $event)
        {
            $event->fav = 1;
            if ($event->image)
            {
                $event->image = asset('images/events/'.$event->image);
            }
        }

        return $user;
    }


    public function removeFromFav($id)
    {
        $user = Auth::user();

        $user =   DB::transaction(function () use($user , $id) {
            $user->favouriteEvents()->detach($id);
            return $user;
        });
        foreach ($user->favouriteEvents as $event)
        {
            $event->fav = 1;
            if ($event->image)
            {
                $event->image = asset('images/events/'.$event->image);
            }
        }
        return response()->json($user);
    }

    public function favEvents()
    {
        $favEvents = User::with('favouriteEvents')->find(Auth::id());
        return $favEvents;
    }


    public function nearByEvents(Request $request) : JsonResponse
    {
        $array = array();
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'long' => 'required',
            'distance' => 'required',
            'unit' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }

        $events = Event::with('masajid')
            ->whereDate('date' , '>=' , Carbon::now()->toDateString())
            ->get();

        foreach ($events as $event)
        {
            $event->distance = $this->distance($request->lat , $request->long , $event->masajid->lat, $event->masajid->long  , $request->unit);
            $event->unit = $request->unit;
            if ($event->distance <= $request->distance) {
                $array[] = $event;
            }
        }
        if (count($array) === 0 )
        {
            return response()->json(['error' => 'No data found'], 404);
        }

        return response()->json($array);
    }

}
