<?php

namespace App\Http\Controllers\Web;

use App\Model\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::where('id',1)->first();
        return view('pages.Settings.index', compact('setting'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function addAboutUS(Request $request)
    {
        $setting = Setting::find(1);
        $setting ?? $setting = new Setting();
        $setting->about_us = $request->about_us;
        $setting->save();

        return redirect()->back();
    }

    public function addTermsAndConditions(Request $request)
    {
        $setting = Setting::find(1);
        $setting ?? $setting = new Setting();
        $setting->terms_and_conditions = $request->terms_and_conditions;
        $setting->save();
        return redirect()->back();
    }


    public function showAboutUs() {
        $setting = Setting::find(1);
        return view('pages.Settings.aboutUs', compact('setting'));
    }

    public function showTermsAndConditions() {
        $setting = Setting::find(1);
        return view('pages.Settings.termsAndConditions', compact('setting'));
    }
}
