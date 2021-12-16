<?php

namespace App\Scopes;

use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AdminScope implements Scope
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
        $user_id = Auth::user()->id;
        $team_id = Auth::user()->team_id;
        $office_id = Auth::user()->office_id;
        $broker_id = Auth::user()->broker_id;

        $builder->where($model->getTable().'.user_id', '=', $user_id);
        if ( ($team_id != null && $team_id > 0) )
            $builder->orWhere($model->getTable().'.team_id', '=', $team_id);
        if ( ($office_id != null && $office_id > 0) )
            $builder->orWhere($model->getTable().'.office_id', '=', $office_id);
        if ( ($broker_id != null && $broker_id > 0) )
            $builder->orWhere($model->getTable().'.broker_id', '=', $broker_id);
        // GHP - V1 - Removing Share List From All Queries
        //$builder->orWhereRaw('json_search('.$model->getTable().'.share_list, "one", '.$user_id.') is not null');
    }
}
