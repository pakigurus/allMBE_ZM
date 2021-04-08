<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    static $SKILL = 0;
    static $INTEREST = 1;

    protected $fillable = ['name', 'display_name'];


    public function userProfile() {
        $this->belongsTo(UserProfile::class, 'skills_id', 'id');
    }
}
