<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuaDuaSubTypes extends Model
{
    protected $fillable = [
        'duas_id',
        'dua_sub_types_id',
    ];

    public $timestamps = false;



    public function dua(): BelongsTo
    {
        return $this->belongsTo(Dua::class, 'duas_id');
    }

    /**
     * Belongs to DuaSubType
     * @return BelongsTo
     */
    public function duaSubType(): BelongsTo
    {
        return $this->belongsTo(DuaSubType::class, 'dua_sub_types_id');
    }

}
