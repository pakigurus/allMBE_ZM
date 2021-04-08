<?php

namespace App\Http\Controllers\Web;

use App\Facades\Utilities\Utilities;
use App\Http\Controllers\Controller;
use App\Model\ReqForDua;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;


class ReqForDuaController extends Controller
{
    use Utilities;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View{
        $rForDua = ReqForDua::with('user')->orderBy('updated_at', 'DESC')->get();
        return view('pages.ReqForDua.reqForDua', compact('rForDua'));
    }

    public function destroy($id) {
        ReqForDua::find($id)->delete();
        return redirect()->back()->with('success','DuaAppeal Deleted successfully');
    }
}

