<?php

namespace App\Http\Controllers\Rest;

use App\Model\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{

    public function index(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'group' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 401);
        }
        $faq = Faq::whereModule($request->group)->get();

        return response()->json($faq);
    }

}
