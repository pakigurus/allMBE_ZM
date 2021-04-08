<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

    protected $fillable = ['rating', 'message', 'email', 'contact', 'device'];



}
