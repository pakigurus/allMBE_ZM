<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Model\IntroductionScreens;
use App\Model\ModulesName;
use Illuminate\Http\Request;

class IntroductionScreensController extends Controller
{
    public function index($module_name) {
        $introList = IntroductionScreens::query()->where("module_name" , $module_name)->orderBy("order", 'ASC')->get();
        return response()->json($introList);
    }


    public function modules() {
        $modules = ModulesName::orderBy('order' , 'asc')->get();
        return response()->json($modules);
    }
}
