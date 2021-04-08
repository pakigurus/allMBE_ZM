<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavDua extends Model
{

    protected $fillable = [
        'duas_id',
        'users_id',
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }


}
