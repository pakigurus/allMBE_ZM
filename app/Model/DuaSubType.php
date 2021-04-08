<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DuaSubType extends Model
{

    public $timestamps = false;

    public function duaTypes(){
       return $this->belongsTo(DuaType::class, 'dua_types_id', 'id');
    }


    public function dua() : belongsToMany
    {
        return $this->belongsToMany(Dua::class, 'dua_dua_sub_types', 'dua_sub_types_id', 'duas_id');
    }
}
