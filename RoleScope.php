<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RoleScope implements Scope
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
            $user_id = Auth::user()->id;
            $role = Auth::user()->role;

            if ($role == "TL")
                $builder->where($model->getTable() . '.team_id', '=', $user_id);
            else if ($role == "OB")
                $builder->where($model->getTable() . '.office_id', '=', $user_id);
            else if ($role == "BR")
                $builder->where($model->getTable() . '.broker_id', '=', $user_id);
            else
                $builder->where($model->getTable() . '.user_id', '=', $user_id);
        }
    }

    public static function boot()
    {
        static::creating(function($model)
        {
            $user = Auth::user();
            $model->user_id = $user->id;
            $model->team_id = $user->team_id;
            $model->office_id = $user->office_id;
            $model->broker_id = $user->broker_id;
        });
    }
}
