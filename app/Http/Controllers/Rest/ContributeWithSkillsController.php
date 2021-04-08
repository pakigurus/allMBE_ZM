<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Utilities\Utilities;
use App\Http\Controllers\Controller;
use App\Model\ContributeWithSkills;
use App\Model\ContributeWithTime;
use App\Model\Masajid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

class ContributeWithSkillsController extends Controller
{
    use Utilities;
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required',
            'phone' => 'nullable',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }

        DB::transaction(function () use ($request){

            $contributeWithSkills = new ContributeWithSkills();
            $contributeWithSkills->name = $request->name;
            $contributeWithSkills->email  = $request->email;
            $contributeWithSkills->phone = $request->phone;
            $contributeWithSkills->lat = $request->lat;
            $contributeWithSkills->long = $request->long;
            $contributeWithSkills->users_id = $request->user_id ?? null;
            $contributeWithSkills->skills_id = $request->skills_id;
            $contributeWithSkills->skills = $request->skills;
            $contributeWithSkills->time_flag = $request->time_flag;
            $contributeWithSkills->description = $request->description;
            $contributeWithSkills->bio = $request->bio;
            $contributeWithSkills->save();

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $contributeWithSkills->users_id = $user->id;
                $contributeWithSkills->save();
            }
            $this->sendVerifyEmail('Contribute With Skills', $contributeWithSkills);

        });

        return response()->json(['message' => 'Successfully Submitted']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\ContributeWithSkills  $contributeWithSkills
     * @return \Illuminate\Http\Response
     */
    public function show(ContributeWithSkills $contributeWithSkills)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\ContributeWithSkills  $contributeWithSkills
     * @return \Illuminate\Http\Response
     */
    public function edit(ContributeWithSkills $contributeWithSkills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Model\ContributeWithSkills  $contributeWithSkills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContributeWithSkills $contributeWithSkills)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\ContributeWithSkills  $contributeWithSkills
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContributeWithSkills $contributeWithSkills)
    {
        //
    }
}
