<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Utilities\Utilities;
use App\Model\Announcement;
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

class AnnouncementController extends Controller
{

    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements= Announcement::with('masajid')->get();
        return $announcements->load('masajid');
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
    public function store(Request $request) :JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'google_masajid_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'contact' => 'required',
            'email' => 'required|email',
            'image'     =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        $image = $request->file('image');

        $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();

        DB::transaction(function () use($masajid, $request, $image){

            //add event
            $announcement = new Announcement();
            if ($request->image)
            {
                //add image
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/announcement/');
                $resize_image = Image::make($image->getRealPath());
                $resize_image->resize(400, 400, function($constraint){
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $image_name);

                $announcement->image = $image_name;
            }
            $announcement->title = $request->title;
            $announcement->description = $request->description;
            $announcement->contact = $request->contact;
            $announcement->email = $request->email;
            $announcement->status = false;
            $announcement->masajids_id = $masajid->id;
            $announcement->save();

            //event linked to user if user is active
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $announcement->user_id = $user->id;
            }
            if ($announcement->save()) {
                $this->sendVerifyEmail('Announcement', $announcement);
            }
            $announcement->save();

        });

        return response()->json(['message' => 'Announcement Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
         $announcement = Announcement::with('masajid')->find($id);

         if (!$announcement)
         {
             return response()->json(['error'=> 'there is no record against this id'], 404);
         }

         return $announcement;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->announcement()->whereId($id)->delete();
        return response()->json(['message' => 'Announcement deleted Successfully']);
    }



    public function userAnnouncements()
    {
        $user = User::with('announcement')->find(Auth::id());
        return $user;
    }


    public function userSingleAnnouncements($id)
    {
        $user = Auth::user();
        $announcement = Auth::user()->announcement()->where(['id'=>$id])->first();
        return $announcement;
    }



    public function addToFav(Announcement $id)
    {
        $user = Auth::user();

        $user->favouriteAnnouncements()->syncWithoutDetaching($id);
        foreach ($user->favouriteAnnouncements as $announcement)
        {
            $announcement->fav = 1;
        }
        return response()->json($user, 200);
    }


    public function favAnnouncements() :JsonResponse
    {
        $favEvents = User::with('favouriteAnnouncements')->find(Auth::id());
        foreach ($favEvents->favouriteAnnouncements as $event)
        {
            $event->fav = 1;
        }
        return response()->json($favEvents, 200);
    }


    public function removeFromFav($id): JsonResponse
    {
        $user = Auth::user();

        $user =   DB::transaction(function () use($user , $id) {
            $user->favouriteAnnouncements()->detach($id);
            return $user;
        });
        foreach ($user->favouriteAnnouncements as $announcement)
        {
            $announcement->fav = 1;
        }
        return response()->json($user, 200);
    }


    public function nearByAnnouncements(Request $request) : JsonResponse
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

        $announcements = Announcement::with('masajid')->get();

        foreach ($announcements as $announcement)
        {
            $announcement->distance = $this->distance($request->lat , $request->long , $announcement->masajid->lat, $announcement->masajid->long  , $request->unit);
            $announcement->unit = $request->unit;

            if ($announcement->distance <= $request->distance) {
                $array[] = $announcement;
            }
        }
        if (count($array) === 0 )
        {
            return response()->json(['error' => 'No data found'], 404);
        }

        return response()->json($array);
    }
}
