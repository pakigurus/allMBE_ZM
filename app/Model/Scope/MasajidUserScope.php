<?php

namespace App\Model\Scope;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MasajidUserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()) {
            if (Auth::user()->is_masajid == 1 && !request()->is('api/*')) {
                $builder->whereHas('masajid', function ($query){
                    return $query->whereHas('masajidUser' , function ($query){
                        return $query->where('users_id' , Auth::id());
                    });
                });
            }
        }
    }
}
