<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IntroductionScreens extends Model
{


    public function getImageAttribute($name) {
        return asset('/images/introscreens/'). "/" .$name;
    }
}
