<?php

namespace App\Http\Controllers\Web;

use App\Model\Announcement;
use App\Model\Event;
use App\Model\Masajid;
use App\Model\NonEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class EventsController extends Controller
{
    public $relation = ['masajid', 'user'];


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() :View
    {
        $events = Event::with('masajid')->get();
//        dd($events);
        foreach ($events as $event)
        {
            if ($event->image)
            {
                $event->image = asset('images/events/'.$event->image);
            }
            $event->time = date("g:i a", strtotime($event->time));
            $event->date = date('d M Y', strtotime($event->date));
        }

        $non_events = NonEvent::query()->get();
        return view('pages.Events.allEvents',compact('events' , 'non_events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():View
    {
        $masajids=Masajid::where('non_masajid' , 0)->select('google_masajid_id' , 'name')->get();
        $non_masajids=Masajid::where('non_masajid' , 1)->select('google_masajid_id' , 'name')->get();
        return view('pages.Events.addEvents',compact('masajids', 'non_masajids'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'google_masajid_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'time' => 'required',
            'contact' => 'required',
            'email' => 'required',
            'link' => 'nullable',
            'message' => 'nullable',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $image = $request->file('image');

        $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();
        DB::transaction(function () use($masajid, $request, $image){
            //add event
            $event = new Event();

            if ($request->image){

                $image = $request->file('image');
                $input['image'] = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/events/');
                $image->move($destinationPath, $input['image']);
                $event->image = $input['image'];
            }

            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = Carbon::parse($request->date)->toDateString();
            $event->time = Carbon::parse($request->time)->toTimeString();
            $event->contact = $request->contact;
            $event->email = $request->email;
            $event->link = $request->link;
            $event->message = $request->message;

            $event->address = $request->address;
            $event->masajids_id = $masajid->id;
            $event->save();

        });

        return redirect()->back()->with('success','Event Added Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) : View
    {
        $event=Event::with($this->relation)->find($id);
        $event->date = Carbon::parse($event->date)->format('d M Y ') ;
        return view('pages.Events.viewSingleEvent',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events=Event::with($this->relation)->find($id);
        $masajids=Masajid::all();
      return view('pages.Events.editEvent',compact('events','masajids'));
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
        $validator = Validator::make($request->all(), [
            'google_masajid_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'time' => 'required',
            'contact' => 'required',
            'email' => 'required',
            'link' => 'nullable',
            'message' => 'nullable',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imageName=$request->hiddenImage;
        if ($request->image){
            //unlink old image
            if($imageName!=null && file_exists(public_path('images/events/'.$imageName))){
                unlink(public_path('images/events/'.$imageName));
            }

            //Upload new image
            $image = $request->file('image');

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/events/');
            $image->move($destinationPath, $imageName);
        }

        $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();

        DB::transaction(function () use($masajid, $request,$id,$imageName){

            //add event
            $event = Event::find($id);
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = Carbon::parse($request->date)->toDateString();
            $event->time = Carbon::parse($request->time)->toTimeString();
            $event->contact = $request->contact;
            $event->email = $request->email;
            $event->link = $request->link;
            $event->message = $request->message;
            $event->image = $imageName;
            $event->address = $request->address;
            $event->masajids_id = $masajid->id;
            $event->update();

        });

        return redirect()->back()->with('success','Updated Successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $events=Event::find($id);
        $events->delete();
        return redirect()->back()->with('success','Event Deleted Successfully');
    }
    public function ViewSingleAnnouncement($id){
        $announcement=Announcement::find($id);
        $masjidName=Masajid::find($id)->name;
        return view('pages.Events.viewSingleAnnouncement',compact('announcement','masjidName'));
    }
    public function approveEvent(Request $request,$id){
        $event=Event::find($id);
        if ($request->status){
            $event->status=1;
            $event->update();
        }
        else{
            $event->status=0;
            $event->update();
        }
    }


}
