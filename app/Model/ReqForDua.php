<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReqForDua extends Model
{

    protected $fillable = ['user_id', 'email', 'title', 'user_name', 'contact_no', 'appeal', 'location', 'ip', 'is_secret', 'status'];
    protected $appends = ['remaining_days'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }

    public function getRemainingDaysAttribute(){
        $current = Carbon::now();
        $updated_date = Carbon::parse($this->updated_at)->addDays(7);

        return [
            'status' => $updated_date > $current ? true : false ,
            'text' => $updated_date->diffForHumans($current),
        ];
    }
}
