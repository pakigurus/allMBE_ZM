<?php

namespace App\Http\Controllers\Web;

use App\Model\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FaqController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():View
    {
        $faqs= Faq::all()->sortByDesc('id');
        return view('pages.FAQ.allFAQ',compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.FAQ.createFAQ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $faq= new Faq();
       $faq->question= $request->question;
       $faq->answer= $request->answer;
       $faq->module= $request->module;
       $faq->save();
       return redirect()->back()->with('success','FAQ Added Successfully');
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
        $faq=Faq::find($id);
        return view('pages.FAQ.editFAQ',compact('faq'));
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
        $faq= Faq::find($id);
        $faq->question=$request->question;
        $faq->answer=$request->answer;
        $faq->module=$request->module;
        $faq->update();

        return redirect()->back()->with('success','Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq= Faq::find($id);
        $faq->delete();
        return redirect()->back()->with('success','Deleted successfully');
    }
}
