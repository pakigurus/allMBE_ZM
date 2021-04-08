<?php

namespace App\Http\Controllers\Rest;

use App\Model\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function foo\func;

class FeedbackController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer',
            'email' => 'required|email',
            'device' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        DB::transaction(function () use($request){
            $feedback = new Feedback();
            $feedback->rating = $request->rating;
            $feedback->message = $request->message;
            $feedback->email = $request->email;
            $feedback->contact = $request->contact;
            $feedback->contact = $request->contact;
            $feedback->device = $request->device;
            $feedback->save();
        });

        return response()->json(['message'=> 'Feedback Added Successfully']);
    }

    public function index() {
        $feedback = Feedback::all();
        return view('pages.Feedback.feedback', compact('feedback'));
    }

}
