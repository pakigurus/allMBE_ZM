<?php

namespace App\Http\Controllers\Web;

use App\Model\Masajid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MasajidController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public $relation = ['event', 'announcement', 'user'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : View
    {
        $AllMasajid = Masajid::withCount($this->relation)->where('status' , 1)->get();
        $BanPlaces = Masajid::withCount($this->relation)->where('status' , 0)->get();
        $MasajidName = Masajid::withCount($this->relation)->get();
        $MasajidUnique = $MasajidName->unique(function($result){
            return strtolower($result->name) . strtolower($result->address);
        });
        $MasajidDuplicate = $MasajidName->diff($MasajidUnique);
        return view('pages.Masajid.allMasajid',compact('AllMasajid', 'BanPlaces', 'MasajidDuplicate'));
    }


    public function mapsView() : View
    {
        $AllMasajid = Masajid::withCount($this->relation)->get();
        return view('pages.Masajid.mapViewMasajids',compact('AllMasajid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():View
    {
        return view('pages.Masajid.createMasjid');
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
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
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
                $masajid->save();
            }
        });
        return redirect()->back()->with('success','Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id):View
    {
        $masajid = Masajid::with($this->relation)->find($id);
        return view('pages.Masajid.masajidAllDetails', compact('masajid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $masajid = Masajid::with($this->relation)->find($id);
        return view('pages.Masajid.editMasajid',compact('masajid'));
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
        $masajid=Masajid::find($id);
        $masajid->google_masajid_id=$request->google_masajid_id;
        $masajid->name=$request->name;
        $masajid->address=$request->address;
        $masajid->lat=$request->lat;
        $masajid->long=$request->long;
        $masajid->save();

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
        $masajid= Masajid::find($id);
//        $masajid->delete();
        return redirect()->back()->with('success','You cannot delete any masajid, this functionality is disabled from backend');
    }

    public function report($id)
    {
        $masajid = Masajid::where('id', $id)->first();
        $masajid->status =  $masajid->status == 1 ? 0 : 1;
        $masajid->save();
        return redirect()->back()->with('success','Action Perform successfully');
    }


    public function feedANeed($id)
    {
        $masajid = Masajid::where('id', $id)->first();
        $masajid->feed_need =  $masajid->feed_need == 1 ? 0 : 1;
        $masajid->save();
        return redirect()->back()->with('success','Action Perform successfully');
    }
}
