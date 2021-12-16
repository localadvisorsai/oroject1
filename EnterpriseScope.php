<?php

namespace App\Scopes;

use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EnterpriseScope implements Scope
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
            $builder->where($model->getTable() . '.enterprise_id', '=', Auth::user()->enterprise_id);
        }
    }

    public static function boot()
    {
        static::creating(function($model)
        {
            $user = Auth::user();
            $model->enterprise_id = $user->enterprise_id;
        });
    }

    // Relationship with Enterprise

    public function enterprise() {
        return $this->belongsTo('App\Enterprise');
    }
}
