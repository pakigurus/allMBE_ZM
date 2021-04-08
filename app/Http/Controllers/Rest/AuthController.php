<?php

namespace App\Http\Controllers\Rest;

use App\Facades\Google\GoogleApi;
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

class AuthController extends Controller
{

    public $successStatus = 200;

    public function login(Request $request) : JsonResponse{

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] = Auth::user()->name;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }


    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
        $user->delete();
        return response()->json(['logout' => 'User Logout successfully'], $this->successStatus);
    }


    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
//            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

       $user = DB::transaction(function () use ($input){
            $user = User::with('userProfile')->create($input);
            $token = mt_rand(1000000000, 9999999999);
            $user->userProfile()->firstOrCreate(['email_verification'=>$token]);
            $user->userProfile()->update(['email_verification'=>$token]);
            $data = array('name'=> $user->first_name, 'body'=> 'A test mail', 'token' => $token);
            Mail::send('EmailVerificationMail', $data, function($message) use ($user) {
                $message->to($user->email, $user->first_name.' '.$user->last_name)
                    ->subject('Email Verification Mail');
                $message->from('web.allmasajid@net','Email Verification Mail');
            });
            return $user;
        });

        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);

    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' =>$validator->errors()->first()], 401);
        }

        $user = User::whereEmail($request->email)->first();
        DB::transaction(function () use($user){
            $token = mt_rand(1000000000, 9999999999);
            $user->password = Hash::make($token);
            $user->save();
            $data = array('name'=> $user->first_name, 'body'=> 'A test mail', 'token' => $token);
            Mail::send('PasswordResetMail', $data, function($message) use($user){
                $message->to($user->email, $user->first_name.' '. $user->last_name)
                    ->subject('Password Reset Mail');
                $message->from('web.allmasajid@net','Password Reset Mail');
            });
        });

        return response()->json(['message'=> 'Password generated successfully and sent to your email address']);

    }


}

