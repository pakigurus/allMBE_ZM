<?php

namespace App\Http\Controllers\Web;

use App\Model\Announcement;
use App\Model\Event;
use App\Model\Masajid;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CSVExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function csvExport($param) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$param}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        if($param == "masajid") {
            $list = Masajid::all()->toArray();
        } elseif ($param == "announcement") {
            $list = Announcement::all()->toArray();
        } elseif($param == 'event') {
            $list = Event::all()->toArray();
        }

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers); //use Illuminate\Support\Facades\Response;

    }

}
