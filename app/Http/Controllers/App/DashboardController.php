<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Rest\UtilController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{

    public function index() {

        $setting = Request::create('setting');
        $setting->query->add(['setting'=> 0]);

        //send request to direct controller, TODO: before getting full setting options in dashboard
        $wfdaysClass = new UtilController();
        $data = $wfdaysClass->getWFDays($setting);
        $wfd = $data->getOriginalContent();
        return view('App.Dashboard.Dashboard' , compact('wfd'));
    }
}
