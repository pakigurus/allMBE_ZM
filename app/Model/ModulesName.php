<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModulesName extends Model
{
    protected $table = 'modules_name';

    public function getImageAttribute($name) {
        return asset('/images/introscreens/'). "/" .$name;
    }


}
