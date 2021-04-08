<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AsrIqamah extends Model
{
    public $table = 'asr_iqamah';

    protected $fillable = ['time', 'to_date' , 'end_date' , 'status', 'user_id', 'user_email', 'masajids_id'];


    public function masajid()
    {
        return $this->belongsTo(Masajid::class, 'masajids_id', 'id');
    }
}
