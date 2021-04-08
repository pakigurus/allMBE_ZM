<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class DuaType extends Model
{






    public function duaSubTypes() :  HasMany {
        return $this->hasMany(DuaSubType::class,'dua_types_id', 'id');
   }


}
