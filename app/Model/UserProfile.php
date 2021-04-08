<?php

namespace App\Model;

use App\Models\Projects;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Model
{


    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $with = [
        'skill'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }


    public function UpdateOrInsert($data)
    {

        $userProfile = UserProfile::where('user_id', Auth::id())->first();
        if ($userProfile)
        {
            $userProfile->contact = $data['contact'];
            $userProfile->save();
        }else{
            $userProfile = new UserProfile();
            $userProfile->contact = $data['contact'];
            $userProfile->user_id = Auth::id();
            $userProfile->save();
        }
        return $userProfile;
    }


    public function skill(){
       return $this->hasOne(Skills::class, 'id', 'skills_id');
    }

}
