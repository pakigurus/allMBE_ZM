<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NonEvent extends Model
{
    protected $guarded;
    use SoftDeletes;


    public function getImageAttribute($value) {
        return ($value) ? asset('images/events/'.$value) : null;
    }

}
