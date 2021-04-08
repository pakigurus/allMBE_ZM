<?php

namespace App\Http\Controllers\Web;

use App\Facades\Utilities\Utilities;
use App\Model\Masajid;
use App\Model\UserMasajid;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
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
    public function index() : View
    {
        $users= User::where('admin_create',1)->orderByDesc("id")->get();
        return view('pages.UserManagement.allUsers',compact('users'));
    }

    public function appUser() : View
    {
        $users= User::where('admin_create', 0)->orderByDesc("id")->get();
        return view('pages.UserManagement.allAppUsers',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() :View
    {
        return view('pages.UserManagement.addUser');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $password = Hash::make($request->input('val-password'));
        $user=new User();
        $user->first_name=$request->input('first_name');
        $user->last_name=$request->input('last_name');
        $user->email=$request->input('email');
        if ($request->is_masajid){
            $user->is_masajid=1;
        }
        $user->admin_create = 1;
        $user->status = 0;
        $user->password=$password;
        $user->save();
        $this->userVerify($user);

        return redirect()->back()->with('success','Email has been sent to Created User to verify first for login!');
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
        $users=User::find($id);
        return view('pages.UserManagement.editUser',compact('users'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user= User::find($id);
        $user->first_name=$request->input('first_name');
        $user->last_name=$request->input('last_name');
        $user->email=$request->input('email');
        $user->update();

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
        $user=User::find($id);
        $user->forceDelete();
        return redirect()->back()->with('success','Deleted Successfully');
    }
    public function isMasajidUser(Request $request,$id){
        $user=User::find($id);
        if ($request->status){
            $user->is_masajid=1;
            $user->update();
        }
        else{
            $user->is_masajid=0;
            $user->update();
        }
    }
    public function assignMasajid(){
        $users=User::backendUsers()->where('is_masajid',1)->get();
        $masajids=Masajid::all();
        return view('pages.UserManagement.assignMasajid',compact('users','masajids'));
    }
    public function getMasajids($id){
            $userId=$id;
            $assigned=UserMasajid::where('users_id',$id)->get();
            if (count($assigned)){
                foreach ($assigned as $assign){
                    $assignedId[]=$assign->masajids_id;
                }
                    $unassigned=Masajid::whereNotin('id',$assignedId)->get();
            }
            else{
                $unassigned=Masajid::all();
            }
            if (count($assigned)){

                foreach ($assigned as $data){

                    $assignedMasajid[]=Masajid::where('id',$data->masajids_id)->first();
                }
            }
            else{
                $assignedMasajid=[];
            }

            $data = view('pages.UserManagement.masajidViaAjax',compact('assignedMasajid','unassigned','userId'))->render();
            return response()->json(['options'=>$data]);

    }
    public function unAssignMasajids(Request $request){
        foreach ($request->masajids as $masajid){
            $data=UserMasajid::where('masajids_id',$masajid)->first();
            $data->delete();
        }
        return redirect()->back()->with('success','Un Assigned Successfully');
    }
    public function assignMasajidToUser(Request $request){
        foreach ($request->masajids as $masajid){
            $data=new UserMasajid();
            $data->users_id=$request->userId;
            $data->masajids_id=$masajid;
            $data->save();
        }
        return redirect()->back()->with('success','Assigned Successfully');
    }

    public function verifyBackendUser(Request $request) {
        $user = User::find($request->id);
        $user->status = 1;
        $user->save();
        return redirect(url('/'));
    }
}
