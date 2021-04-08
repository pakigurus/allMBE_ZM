<?php

namespace App\Http\Controllers\Rest;
use App\Facades\Utilities\Utilities;
use App\Http\Controllers\Controller;
use App\Model\ReqForDua;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReqForDuaController extends Controller
{
    use Utilities;

    public function index() : JsonResponse{
        $rForDuas = ReqForDua::where('updated_at' ,'>=', Carbon::now()->subDays(7))->where('status' , 1)->orderBy('updated_at', 'DESC')->get()->paginate(5);
        return response()->json($rForDuas);
    }

    //create
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'email' => 'required|email',
            'contact_no' => 'nullable',
            'title' => 'required',
            'appeal' => 'required',
            'is_secret' => 'required',
            'location' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }

        $request->request->add(['ip'=> $request->ip()]);
        if($request->contact_no == null || ""){
            $request->request->add(['contact_no'=> '']);
        }
        //RforDua linked to user if user is active
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $request->request->add(['user_id'=> $user->id]);
        }
        $data = ReqForDua::create($request->all());
        $this->sendVerifyEmail('Dua Appeal', $data);

        return response()->json(['message' => "Dua submitted Successfully"]);
    }

    public function userDuaList() {
        return ReqForDua::whereUserId(Auth::id())->orderBy('id', 'DESC')->get()->paginate(5);
    }

    public function userDua($id) {
        return ReqForDua::find($id);
    }

    public function userDuaEdit($id , Request $request) {
        $req = ReqForDua::find($id);
        $req->timestamps = false;
        if($request->contact_no == null || ""){
            $request->request->add(['contact_no'=> '']);
        }
        $req->fill($request->all());
        $req->save();
        return response()->json(['message' => 'Dua Appeal updated successfully']);
    }

    public function userDuaExtend($id) {
        $req = ReqForDua::find($id);
        $req->touch();
        return response()->json(['message' => 'Dua Appeal Extended successfully']);
    }

    public function destroy($id) {
        ReqForDua::find($id)->delete();
        return response()->json(['message' => 'Dua Appeal Deleted successfully']);
    }

}
