<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ContributeWithTime extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id', 'users');
    }

    public function masajid()
    {
        return $this->belongsTo(Masajid::class, 'masajids_id', 'id');
    }

    public function skill()
    {
        return $this->belongsTo(Skills::class, 'skills_id', 'id');
    }

}
