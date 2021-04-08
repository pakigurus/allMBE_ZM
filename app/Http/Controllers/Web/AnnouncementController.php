<?php

namespace App\Http\Controllers\Web;

use App\Model\Announcement;
use App\Model\Masajid;
use App\Model\NonAnnouncement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class AnnouncementController extends Controller
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
        $announcements= Announcement::with('masajid')->get();
        foreach ($announcements as $announcement)
        {
            if ($announcement->image)
            {
                $announcement->image = asset('images/announcement/'.$announcement->image);
            }
        }
         $announcements->load('masajid');

        $non_announcements = NonAnnouncement::query()->get();

        return view('pages.Announcements.allAnnouncements',compact('announcements' , 'non_announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() :View
    {
        $masajids=Masajid::all();
       return view('pages.Announcements.createAnnouncement',compact('masajids'));
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
            'contact' => 'required',
            'email' => 'required',
            'image'     =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
            $announcement = new Announcement();
            if ($request->image){

                $image = $request->file('image');
                $input['image'] = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/announcement/');
                $image->move($destinationPath, $input['image']);
                $announcement->image =  $input['image'];
            }
            $announcement->title = $request->title;
            $announcement->description = $request->description;
            $announcement->contact = $request->contact;
            $announcement->email = $request->email;
            $announcement->masajids_id = $masajid->id;
            $announcement->save();

        });

        return redirect()->back()->with('success','Announcement Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $announcement = Announcement::with('masajid')->find($id);
        return view('pages.Announcements.viewSingleAnnouncement',compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) :View
    {
        $announcement=Announcement::with($this->relation)->find($id);
        $masajids=Masajid::all();
        return view('pages.Announcements.editAnnouncement',compact('announcement','masajids'));
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
            'contact' => 'required',
            'email' => 'required',
            'image'     =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imageName=$request->hiddenImage;
        if ($request->image){
            //unlink old image
            if($imageName!=null && file_exists(public_path('images/announcement/'.$imageName))){
                unlink(public_path('images/announcement/'.$imageName));
            }

            //Upload new image
            $image = $request->file('image');

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/announcement/');
            $image->move($destinationPath, $imageName);
        }

        $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();

        DB::transaction(function () use($masajid, $request,$id,$imageName){

            //add event
            $announcement = Announcement::find($id);
            $announcement->title = $request->title;
            $announcement->description = $request->description;
            $announcement->contact = $request->contact;
            $announcement->email = $request->email;
            $announcement->image = $imageName;
            $announcement->masajids_id = $masajid->id;
            $announcement->update();

        });

        return redirect()->back()->with('success','Announcement Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $events=Announcement::find($id);
        $events->delete();
        return redirect()->back()->with('success','Announcement Deleted Successfully');
    }
    public function approveAnnouncement(Request $request,$id){
        $announcement=Announcement::find($id);
        if ($request->status){
            $announcement->status=1;
            $announcement->update();
        }
        else{
            $announcement->status=0;
            $announcement->update();
        }
    }
}
