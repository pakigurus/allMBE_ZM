<?php

namespace App\Http\Controllers\Rest;


use App\Http\Controllers\Controller;
use App\Model\FeedANeed;
use App\Model\Masajid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FeedANeedController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'masajid_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'focal_person' => Rule::in([1, 0])
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        $masajid = Masajid::whereGoogleMasajidId($request->masajid_id)->first();
        $feedANeed = new FeedANeed();
        $feedANeed->masajids_id = $masajid->id;
        $feedANeed->name = $request->name;
        $feedANeed->email = $request->email;
        $feedANeed->contact_no = $request->contact_no;
        $feedANeed->ntn = $request->ntn;
        $feedANeed->description = $request->description;
        $feedANeed->amount = $request->amount;
        $feedANeed->focal_person = $request->focal_person ?? false;
        $feedANeed->save();

        return response()->json(['message' => 'Request has been submitted']);
    }
}
