<?php

namespace App\Http\Controllers\Web;

use App\Model\Dua;
use App\Model\DuaSubType;
use App\Model\DuaType;
use App\Model\Event;
use App\Model\Masajid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DuaSubTypesController extends Controller
{
    public $relation = ['duaTypes', 'dua'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() : View
    {
        $duaTypes=DuaType::all();
        $duaSubTypes=DuaSubType::with($this->relation)->get();
        foreach ($duaSubTypes as $types){
            if ($types->image)
            {
                $types->image = asset('images/dua/'.$types->image);
            }
        }
      return view('pages.Prayers.addDuaSubType',compact('duaTypes','duaSubTypes'));

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
            'dua_type' => 'required',
            'sub_type_name' => 'required',
            'image'     =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use( $request){
            $duaSubType= new DuaSubType();
            if ($request->image){

                $image = $request->file('image');
                $input['image'] = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/dua/');
                $image->move($destinationPath, $input['image']);
                $duaSubType->image=$input['image'];
            }
            $duaSubType->name=$request->sub_type_name;
            $duaSubType->dua_types_id=$request->dua_type;
            $duaSubType->save();
        });

        return redirect()->back()->with('success','Dua Sub Type Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id):View
    {
        $duaTypes=DuaType::all();
        $duaSubTypes=DuaSubType::with($this->relation)->find($id);
        return view('pages.Prayers.editDuaSubTypes',compact('duaSubTypes','duaTypes'));

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
            'dua_type' => 'required',
            'sub_type_name' => 'required',
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
            if($imageName!=null && file_exists(public_path('images/dua/'.$imageName))){
                unlink(public_path('images/dua/'.$imageName));
            }

            //Upload new image
            $image = $request->file('image');

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/dua/');
            $image->move($destinationPath, $imageName);
        }
        DB::transaction(function () use( $request,$id,$imageName){
            //add event
            $duaSubType = DuaSubType::find($id);
            $duaSubType->name=$request->sub_type_name;
            $duaSubType->dua_types_id=$request->dua_type;
            $duaSubType->image = $imageName;
            $duaSubType->update();
        });


        $duaTypes=DuaType::all();
        $duaSubTypes=DuaSubType::with($this->relation)->get();
        foreach ($duaSubTypes as $types){
            if ($types->image)
            {
                $types->image = asset('images/dua/'.$types->image);
            }
        }
        return view('pages.Prayers.addDuaSubType',compact('duaTypes','duaSubTypes'));
//        return redirect()->back()->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $duaSubType=DuaSubType::find($id);
        $duaSubType->delete();
        return redirect()->back()->with('success','Deleted Successfully');

    }
}
