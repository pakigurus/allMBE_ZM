<?php

namespace App\Http\Controllers\Rest;


use App\Facades\Utilities\Utilities;
use App\Http\Controllers\Controller;
use App\Model\ContributeWithTime;
use App\Model\Masajid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContributeWithTimeController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
//            'google_masajid_id' => 'required',
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
            $masajid = Masajid::whereGoogleMasajidId($request->google_masajid_id)->first();

            $contributeWithTime = new ContributeWithTime();
            $contributeWithTime->name = $request->name;
            $contributeWithTime->email  = $request->email;
            $contributeWithTime->phone = $request->phone;
            $contributeWithTime->lat = $request->lat;
            $contributeWithTime->long = $request->long;
            $contributeWithTime->masajids_id = $masajid->id ?? null;
            $contributeWithTime->users_id = $request->user_id ?? null;
            $contributeWithTime->skills_id = $request->interest_id;
            $contributeWithTime->time_flag = $request->time_flag;
            $contributeWithTime->description = $request->description;
            $contributeWithTime->bio = $request->bio;
            $contributeWithTime->save();

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $contributeWithTime->users_id = $user->id;
                $contributeWithTime->save();
            }
            $this->sendVerifyEmail('Contribute With Time', $contributeWithTime);

        });


        return response()->json(['message' => 'Successfully Submitted']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\ContributeWithTime  $contributeWithTime
     * @return \Illuminate\Http\Response
     */
    public function show(ContributeWithTime $contributeWithTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\ContributeWithTime  $contributeWithTime
     * @return \Illuminate\Http\Response
     */
    public function edit(ContributeWithTime $contributeWithTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContributeWithTime  $contributeWithTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContributeWithTime $contributeWithTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\ContributeWithTime  $contributeWithTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContributeWithTime $contributeWithTime)
    {
        //
    }
}
