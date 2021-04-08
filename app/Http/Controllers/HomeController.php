<?php

namespace App\Http\Controllers;

use App\Model\Announcement;
use App\Model\Event;
use App\Model\Masajid;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->admin_create == 0 and Auth::user()->is_admin == 0 and Auth::user()->is_masajid == 0)
        {
            return redirect()->route('user.dashboard');
        }

        $masajidCount = Masajid::all()->count();
        $eventCount = Event::all()->count();
        $announcementCount = Announcement::all()->count();
        $userCount = User::all()->count();
        return view('home', compact('masajidCount', 'eventCount' , 'announcementCount', 'userCount'));
    }
}
