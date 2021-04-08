<?php

namespace App\Http\Controllers\Web;

use App\Facades\Utilities\Utilities;
use App\Model\Dua;
use App\Model\DuaDuaSubTypes;
use App\Model\DuaSubType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use function foo\func;
use function GuzzleHttp\Promise\all;

class DuaController extends Controller
{

    use Utilities;


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
        $Duas=Dua::with('duasubtypes')->get();
       return view('pages.Prayers.allDua',compact('Duas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.Prayers.addDua');
    }


    public function addDua(Request $request){
        Dua::create($request->except('_token'));
        return redirect()->back()->with('success','Dua added successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        if (isset($request->unlinked) ){

            foreach ($request->unlinked as $key=> $dua){
                $Dua_dua_sub_types= new DuaDuaSubTypes();
                $Dua_dua_sub_types->dua_sub_types_id=$dua;
                $Dua_dua_sub_types->duas_id=$request->duaId;
                $Dua_dua_sub_types->save();
            }
            return redirect()->back()->with('success','Linked Successfully');
        }
//        dd($request->linked);
        elseif(isset($request->linked) ){
            foreach ($request->linked as $key=> $dua){
                $Dua_dua_sub_types= DuaDuaSubTypes::find($dua);
                $Dua_dua_sub_types->delete();
            }
            return redirect()->back()->with('success','Unlinked Successfully');
        }

        else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ids=[];
        $Dua=Dua::find($id);
        $Dua_dua_sub_types=DuaDuaSubTypes::with('duasubtype')->where('duas_id',$id)->get();

        foreach ($Dua_dua_sub_types as $dua){
            $ids[]=$dua->duasubtype->id;
        }
        $DuaSubType=DuaSubType::whereNotIn('id',$ids)->get();
        return view('pages.Prayers.duaLinkage',compact('Dua','Dua_dua_sub_types','DuaSubType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $dua = Dua::find($id);
        return view('pages.Prayers.editDua',compact('dua'));
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
        Dua::where('id' , $id)->update($request->except('_token', '_method'));
        return redirect(url('/admin/dua'))->with('success','Dua edit successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dua=Dua::find($id);
        $dua->delete();
        return redirect()->back()->with('success','Dua deleted successfully');
    }

    public function importDua(Request $request) {
        $validator = Validator::make($request->all(), [
            'file'     =>  'required|file|mimes:csv,txt'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $path = public_path('images');
        $file->move($path, $name);

        //get file after saving
        $csv = $path.'/'.$name;

        $customerArr = $this->csvToArray($csv);

        //delete the file after generate array
        File::delete($csv);

        if (!$customerArr)
        {
            return 'error';
        }
        DB::transaction(function () use($customerArr){
            for ($i = 0; $i < count($customerArr); $i ++)
            {
                Dua::firstOrCreate($customerArr[$i]);
            }
        });

        return redirect()->back()->with('success','Dua Sheet Successfully import');
    }

    public function sampleDownload()
    {
        $path = public_path('utilities/dua_sample.csv');
        return response()->download($path);
    }
}
