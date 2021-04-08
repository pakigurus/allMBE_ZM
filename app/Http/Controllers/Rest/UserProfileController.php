<?php

namespace App\Http\Controllers\Rest;

use App\Model\UserProfile;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : JsonResponse
    {
        $user = User::find(\request()->user()->id);
        if($user->userProfile) {
            $user->userProfile->image ? $user->userProfile->image = asset('images/profile/'.$user->userProfile->image) : $user->userProfile->image = asset('images/icon-app.png');
        }
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) :JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
            'contact' => 'nullable',
            'skill_name' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
       $response = DB::transaction(function () use($request){
           $response =response()->json(['message'=> "Profile Updated Successfully"], 200);
            if ($request->first_name && $request->last_name && $request->email)
            {
                $user = User::find(Auth::id());
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $exist = User::where(['email' => $request->email])->where( 'id' , '!=', Auth::id())->exists();
                if ($exist) {
                   return $response = response()->json(['error' => 'The email has already been taken.'], 401);
                }
                $user->email = $request->email;
                $user->save();
            }
                $userProfile = UserProfile::whereUserId($user->id)->first();
                if (!$userProfile) {
                    $userProfile = new UserProfile();
                    $userProfile->user_id = $user->id;
                }

                $userProfile->contact = $request->contact ?? null;
                $userProfile->skills = $request->skill_name ?? null;
                $userProfile->skills_id = $request->skill_id ?? null;
                $userProfile->save();


            return $response;
        });

        return $response;
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        dd('sas');
    }


    public function destroy($id)
    {
        //
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        $image = $request->file('image');

       $user = DB::transaction(function () use ($image) {

            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/profile/');
            $resize_image = Image::make($image->getRealPath());
            $resize_image->resize(400, 400, function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $image_name);

            $user = User::find(Auth::id());
            $user->userProfile()->update(['image' => $image_name]);

            $user->userProfile->image = asset('/images/profile/'.$user->userProfile->image);

            return $user;
        });

        return response()->json($user);
    }

    //send mail for verification
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'     =>  'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        if ($request->type == 'email')
        {
            DB::transaction(function (){
                $token = mt_rand(1000000000, 9999999999);
                User::find(Auth::id())->userProfile()->update(['email_verification'=>$token]);
                $data = array('name'=> Auth::user()->first_name, 'body'=> 'A test mail', 'token' => $token);
                Mail::send('EmailVerificationMail', $data, function($message) {
                    $message->to(Auth::user()->email, Auth::user()->first_name.' '.Auth::user()->last_name)
                        ->subject('Email Verification Mail');
                    $message->from('web.allmasajid@net','Email Verification Mail');
                });
            });
            return response()->json(['message'=> "Verification code successfully sent to your email address"], 200);
        }
    }


    //verify code
    public function verifyCode(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'code'     =>  'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        if ($type == 'email')
        {
                $userProfile = UserProfile::where(['user_id'=> Auth::id(), 'email_verification' => $request->code])->first();
                if ($userProfile ==  null){
                    return response()->json(['error' => 'User Verification not recognised'], 403);
                }
                UserProfile::where(['user_id'=> Auth::id(), 'email_verification' => $request->code])->update(['email_verification_status'=> true , 'email_verification' => null]);

            return response()->json(['message'=> 'Email verify successfully'], 200);
        }

    }
    // this function mehtod is post for varify contact OTP
    
    public function verifyCodeOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact'     =>  'required',
            'status'     =>  'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }else{
            $userProfile = UserProfile::where(['user_id'=> Auth::id(), 'contact' => $request->contact])->first();
            if ($userProfile ==  null){
                return response()->json(['error' => 'User Verification Contact number not recognised'], 403);
            }
            $userProfile->contact_verification_status = ($userProfile->contact_verification_status === true) ? true: $request->status;
            $userProfile->contact_verification = null;
            $userProfile->update();

            return response()->json(['message'=> 'Contact verify successfully'], 200);
        }

    }
    // this function mehtod is post for varify contact OTP

    //update password
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'     =>  'required',
            'new_password'     =>  'required',
            'confirm_password'     =>  'required|same:new_password'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
            $user = DB::table('users')->where('id', Auth::id())->first();

            if(Hash::check($request->current_password, $user->password))
            {
                $user_id = Auth::User()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = Hash::make($request->new_password);
                $obj_user->save();
            }
            else
            {
                return response()->json(['error' => 'Please enter correct current password'], 400);
            }

        return response()->json(['message' => 'password updated Successfully']);
    }
}
