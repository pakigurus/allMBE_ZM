<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserMasajid extends Model
{

    protected $table = 'users_masajids';

    public $timestamps = false;

    protected $fillable = ['masajids_id', 'users_id'];
}
