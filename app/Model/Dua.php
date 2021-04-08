<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Dua extends Model
{

    protected $table = 'duas';

    protected $fillable = ['dua', 'name', 'translation', 'transliteration', 'urdu_translation', 'reference', 'urdu_name'];

    protected $appends = ['second_translation'];

    protected static function boot(): void
    {
        parent::boot();

    }


    public function duaSubTypes() : belongsToMany
    {
        return $this->belongsToMany(DuaSubType::class, 'dua_dua_sub_types', 'duas_id', 'dua_sub_types_id');
    }

    public function user(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favouritable', 'favouritable');
    }


    /**
     * @return mixed
     */
    public function getSecondTranslationAttribute()
    {
        if (request()->header('translation')) {
            $translation = request()->header('translation');
            if ($translation == 'urdu') {
                return $this->urdu_translation;
            }
        } else {
            return $this->urdu_translation;
        }
    }
}
