<?php

namespace App\Http\Controllers\Rest;

use App\Model\Dua;
use App\Model\DuaSubType;
use App\Model\DuaType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function foo\func;

class DuaController extends Controller
{

    public function create()
    {
        //
    }



    public function show($id)
    {
        $dua = Dua::with('duaSubTypes')->find($id);
        $dua->fav = 0 ;

        $check = null;
        // check dua is favourite or not
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $check = $dua->user()->where('user_id' , $user->id)->exists();
        }
        $check ? $dua->fav = 1 : $dua->fav = 0;
        return response()->json($dua);
    }


    public function destroy($id)
    {
        //
    }

    // Get SUB TYPES list with give main type id
    public function duaType($id){
        $duaType = DuaType::with('duaSubTypes')->find($id);
        return response()->json($duaType);
    }

    // Get Dua list against sub type
    public function duaSubType($id){
        $duaSubType = DuaSubType::with('dua')->find($id);


        // check dua is favourite or not
        $check = null;
        foreach ($duaSubType->dua as $dua)
        {
            if (Auth::guard('api')->check()) {
               $user = Auth::guard('api')->user();
               $check = $dua->user()->where('user_id' , $user->id)->exists();
            }
            $check ? $dua->fav = 1 : $dua->fav = 0;
        }

        return response()->json($duaSubType);
    }

    //Add dua in favourite list
    public function addToFav($id)
    {
        $user = User::find(Auth::id());
           $user = DB::transaction(function () use ($user, $id) {
                $user->dua()->syncWithoutDetaching($id);
                return $user;
            });
        $user->dua;
        return response()->json($user);
    }


    //Remove Favourite dua
    public function removeFromFav($id)
    {
        $user = User::find(Auth::id());
        $user = DB::transaction(function () use ($user, $id) {
            $user->dua()->detach($id);
            return $user;
        });
        $user->dua;
        return response()->json($user);
    }

    //User Favourite dua list
    public function favDuaList()
    {
        $user = \request()->user()->load('dua');
        return $user;
    }

}
