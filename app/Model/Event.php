<?php

namespace App\Model;

use App\Model\Scope\MasajidUserScope;
use App\Model\Scope\StatusScope;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use function foo\func;

class Event extends Model
{

    protected $table = 'events';

    use SoftDeletes;

    protected $fillable = ['title', 'description', 'google_masajid_id', 'date', 'time', 'month', 'contact', 'email', 'link', 'message','address','image', 'status'];

    protected $appends = ['fav'];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new StatusScope());
        static::addGlobalScope(new MasajidUserScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

    public function masajid()
    {
        return $this->belongsTo(Masajid::class, 'masajids_id', 'id');
    }

    public function favouriteUsers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favouritable', 'favouritable');
    }

    public function getImageAttribute($value) {
        return ($value) ? asset('images/events/'.$value) : null;
    }

    public function getFavAttribute(): int
    {
        $check = 0;
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $check = $this->favouriteUsers()->where('user_id' , $user->id)->exists();
        }
        return  ($check) ? 1 :  0;
    }
}

