<?php

namespace App\Http\Controllers\Web;

use App\Facades\Google\GoogleApi;
use App\Facades\Utilities\Utilities;
use App\Model\Masajid;
use Illuminate\Support\Str;
use simple_html_dom;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCode;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class QrCodeController extends Controller
{

    use Utilities;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        return view('pages.QrCode.createQrCode');
    }

    public function generate(Request $request) {
        $data = $request;

        QrCode::format('png')->size(400)->style('round')->merge('/public/images/'.$request->media , .2)->generate($request->url , '../public/images/qrcode.png');
        return view('pages.QrCode.viewQrCode', compact('data'));
    }


    public function download()
    {
        return response()->download(public_path('/images/qrcode.png'));
    }


    public function updateMasajidPlaceData() {
        $googleApi = new GoogleApi();
        $masajids = Masajid::all();

       foreach ($masajids->where('country', null)->values() as $masajid) {
           $rawResponse = $googleApi->masajidPlaceCountry($masajid);
           $results = data_get($rawResponse, 'results');

           foreach ($results[0]->address_components as $address) {
               if (in_array("locality", $address->types)) {
                   $masajid->city = $address->long_name;
               } else if(in_array("country", $address->types)){
                   $masajid->country = $address->long_name;
               } else if(in_array("administrative_area_level_1", $address->types)){
                   $masajid->state = $address->long_name;
               }
           }
           $masajid->save();
       }

       return response()->json(['message' => 'Successfully all places added against masajid']);
    }

    public function generateKey() {
        $masajids = Masajid::all();
        foreach ($masajids->where('country', '!=',null)->values() as $masajid) {
            //check if letter have no arabic notations
           if (preg_match('~[a-z]~ui', $masajid->country) && preg_match('~[a-z]~ui', $masajid->city)) {
               $key = $this->generateSurrogateId($masajid->country, $masajid->city, $masajid->id);
               $masajid->update(['surrogate_id' => $key]);
           }
        }
        return response()->json(['message' => 'Successfully generate surrogate keys']);
    }
}
