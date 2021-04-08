<?php

namespace App;

use App\Model\Announcement;
use App\Model\Dua;
use App\Model\Event;
use App\Model\Masajid;
use App\Model\ReqForDua;
use App\Model\UserMasajid;
use App\Model\UserProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password' , 'admin_create' , 'status'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $with = [
        'userProfile'
    ];

    public $appends = ['full_name'];

    public function userProfile() : HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    public function reqForDua() : HasOne
    {
        return $this->hasOne(ReqForDua::class, 'user_id', 'id');
    }


    /**
     * @return MorphToMany
     */
    public function masajid(): MorphToMany {
        return $this->morphedByMany(Masajid::class, 'favouritable', 'favouritable');
    }


    public function event(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id', 'id');
    }


    public function announcement()
    {
        return $this->hasMany(Announcement::class, 'user_id', 'id');
    }

    public function favouriteEvents(): MorphToMany
    {
        return $this->morphedByMany(Event::class, 'favouritable', 'favouritable')
            ->distinct();
    }

    public function favouriteAnnouncements(): MorphToMany
    {
        return $this->morphedByMany(Announcement::class, 'favouritable', 'favouritable')
            ->distinct();
    }

    public function dua(): MorphToMany
    {
        return $this->morphedByMany(Dua::class, 'favouritable', 'favouritable')
            ->distinct();
    }


    public function masajidUser() : BelongsToMany{
        return $this->belongsToMany(Masajid::class, 'users_masajids', 'users_id', 'masajids_id');
    }


    public function getFullNameAttribute () {
        return $this->first_name .' '.$this->last_name;
    }


    public function scopeBackendUsers(Builder $query): Builder
    {
        return $query->where('admin_create', 1);
    }



}
