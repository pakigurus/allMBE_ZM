<?php

namespace App\Http\Controllers\Web;

use App\Model\Announcement;
use App\Model\ContributeWithSkills;
use App\Model\ContributeWithTime;
use App\Model\Event;
use App\Model\NonAnnouncement;
use App\Model\NonEvent;
use App\Model\ReqForDua;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyModulesController extends Controller
{
    public function verifyModules($moduleName , $id) {
        switch ($moduleName) {

            case 'event' ;
            $model = Event::find($id);
            $message = "Event successfully verified";
            break;

            case 'announcement';
            $model = Announcement::find($id);
            $message = "Announcement successfully verified";
            break;

            case 'dua appeal';
            $model = ReqForDua::find($id);
            $message = "Dua Appeal successfully verified";
            break;

            case 'contribute with skills';
            $model = ContributeWithSkills::find($id);
            $message = "Contribute With Skills successfully verified";
            break;

            case 'contribute with time';
            $model = ContributeWithTime::find($id);
            $message = "Contribute With Time successfully verified";
            break;

            case 'non event';
                $model = NonEvent::find($id);
                $message = "Non Masajid Event Time successfully verified";
            break;

            case 'non announcement';
                $model = NonAnnouncement::find($id);
                $message = "Non Masajid Announcement Time successfully verified";
            break;
        }
        $model->status = 1;
        $model->save();
        return view('pages.Extras.moduleVerify', compact('message'));
    }
}
