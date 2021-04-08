<?php

namespace App\Model;

use App\Facades\Utilities\Utilities;
use App\Model\Scope\BlockMasajidScope;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use function foo\func;

class Masajid extends Model
{

    use Utilities;

    protected $fillable = [
        'google_masajid_id', 'name', 'address' , 'latitude', 'longitude', 'surrogate_id', 'feed_need',
    ];

//    protected $withCount = [
//        'user',
//        'event',
//        'announcement'
//    ];

    protected $appends = ['distance'];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(function ($model) {
            if (Auth::check()){
                if ( Auth::user()->is_masajid == 1  and !request()->is('api/*')) {
                    $model->whereHas('masajidUser', function ($query){
                        return $query->where('users_id' , Auth::id());
                    });
                }
            }
        });
    }

    public function masajidUser() : BelongsToMany {
        return $this->belongsToMany(User::class, 'users_masajids', 'masajids_id', 'users_id');
    }

    public function user(){
        return $this->morphToMany(User::class, 'favouritable', 'favouritable');
    }

    public function event()
    {
        return $this->hasMany(Event::class, 'masajids_id', 'id');
    }

    public function announcement()
    {
        return $this->hasMany(Announcement::class, 'masajids_id', 'id');
    }

    public function fajr()
    {
        return $this->hasMany(FajrIqamah::class, 'masajids_id', 'id');
    }

    public function duhr()
    {
        return $this->hasMany(DuhrIqamah::class, 'masajids_id', 'id');
    }

    public function asr()
    {
        return $this->hasMany(AsrIqamah::class, 'masajids_id', 'id');
    }

    public function maghrib()
    {
        return $this->hasMany(MaghribIqamah::class, 'masajids_id', 'id');
    }

    public function isha()
    {
        return $this->hasMany(IshaIqamah::class, 'masajids_id', 'id');
    }

    public function jumah()
    {
        return $this->hasMany(JumahIqamah::class, 'masajids_id', 'id');
    }


    public function getDistanceAttribute() {
        if (request()->get('lat') and request()->get('long') and request()->get('distance')) {
            $distance = $this->distance(request()->get('lat') , request()->get('long')  , $this->lat, $this->long  , request()->get('distance'));
        }
        return $distance ?? "N/A";
    }

}
