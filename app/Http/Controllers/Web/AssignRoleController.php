<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignRoleController extends Controller
{

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
        $users=User::backendUsers()->get();
        $roles=Permission::all();
        return view('pages.RoleManagement.assignRoleToUser',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=User::find($request->user);
        $assignedRoles= $user->permissions;
        if (count($assignedRoles))
        {
            $id=[];
            foreach ($assignedRoles as $data)
            {
                $id[]=$data->id;
            }
            $roles=Permission::whereNotin('id',$id)->get();
        }
        else
        {
            $roles=Permission::all();
        }

        return redirect('admin/assign-role')->with(['assignRoles'=>$assignedRoles,'roles'=>$roles,'userId'=>$request->user]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id):View
    {
        $user=User::find($id);
        $roles=Permission::all();
        return view('pages.RoleManagement.assignRoleToUser',compact('user','roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function assignRoleToUser(Request $request){
        $user=User::find($request->userId);
        foreach ($request->unAssignedRoles as $role){
            $user->givePermissionTo($role);
        }
        return redirect()->back()->with('success','Assigned Successfully');

    }
    public function unAssignRole(Request $request){
        $user=User::find($request->userId);
        foreach ($request->AssignedRoles as $role){
            $user->revokePermissionTo($role);
        }
        return redirect()->back()->with('success','Un Assigned Successfully');
    }
}
