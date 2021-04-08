<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionsToRolesController extends Controller
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
        $roles=Role::all();
        $permissions=Permission::all();
        return view('pages.RoleManagement.assignPermissionToRoles',compact('roles','permissions'));
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
    public function store(Request $request)
    {
        if ($request->unassigned_role){
            $role=Role::findById($request->unassigned_role);

            if ($request->permissions == null){
                return redirect()->back()->with('error', 'Please select minimum 1 permission');
            }
            foreach($request->permissions as $data){
                $permission=Permission::findById($data);

                $role->givePermissionTo($permission->name);
            }
            return redirect()->back()->with('success','Assigned successfully');
        }
        if ($request->assigned_role && isset($request->permissions)){
            $role=Role::findById($request->assigned_role);
            $rolePermission=$role->permissions;

            $permissions=$request->permissions;


            if (count($rolePermission))
            {
                $id=[];
                foreach ($rolePermission as $data) {
                    $id[]=$data->id;

                }

                if(count($id)==1)
                {
                    $per=Permission::findById($id[0]);
                    $role->revokePermissionTo($data);
                    return redirect()->back();
                }

                $unchecked=array_diff($id,$permissions);

            }

            if ($unchecked == null){
                return redirect()->back()->with('error', 'Please minimum minimum 1 permission');
            }

            foreach ($unchecked as $data)
            {
                $revokePermissions[]=Permission::findById($data);
            }


            foreach ($revokePermissions as $data)
            {
                $role->revokePermissionTo($data);
            }
            return redirect()->back()->with('success','Un Assigned successfully');
        }
        return redirect()->back()->with('error','Please select minimum 1 permission');
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
        //
    }
    public function getAllPermissions(Request $request){
        if($request->ajax()){
            $role = Role::all();

            $role_id =  $request->id_role;

            $roles=Role::findById($role_id);


            $assignPermission=$roles->permissions;

            if (count($assignPermission))
            {
                $id=[];
                foreach ($assignPermission as $data)
                {
                    $id[]=$data->id;
                }
                $permissions=Permission::whereNotin('id',$id)->get();
            }
            else
            {
                $permissions=Permission::all();
            }
            $allPermissions=Permission::all();
            $data = view('pages.RoleManagement.allPermissions',compact('assignPermission','permissions','role_id', 'role', 'roles'))->render();
            return response()->json(['options'=>$data]);
        }
    }
}
