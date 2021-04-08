<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MaghribIqamah extends Model
{
    public $table = 'maghrib_iqamah';

    protected $fillable = ['minutes', 'status', 'user_id', 'user_email', 'masajids_id'];


    public function masajid()
    {
        return $this->belongsTo(Masajid::class, 'masajids_id', 'id');
    }
}
