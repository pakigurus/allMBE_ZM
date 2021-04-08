<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DuhrIqamah extends Model
{
    public $table = 'duhr_iqamah';

    protected $fillable = ['time', 'to_date' , 'end_date' , 'status', 'user_id', 'user_email', 'masajids_id'];
}
