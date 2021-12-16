<?php

namespace App\Scopes;

class ApprovedScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    
    protected $extensions = ['Restore', 'WithApproval', 'WithoutApproval', 'OnlyApproved'];
    
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
     
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($model->getQualifiedApprovedAtColumn());
    }
    
    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
     
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
        $builder->onDelete(function (Builder $builder) {
            $column = $this->getApprovedAtColumn($builder);
            return $builder->update([
                $column => $builder->getModel()->freshTimestampString(),
            ]);
        });
    }
    
    /**
     * Get the "deleted at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return string
     */
    
    protected function getApprovedAtColumn(Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedApprovedAtColumn();
        }
        return $builder->getModel()->getApprovedAtColumn();
    }
    
    /**
     * Add the restore extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    
    protected function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withApproval();
            return $builder->update([$builder->getModel()->getApprovedAtColumn() => null]);
        });
    }
    /**
     * Add the with-approved extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
     
    protected function addWithApproval(Builder $builder)
    {
        $builder->macro('withApproval', function (Builder $builder, $withApproval = true) {
            if (! $withApproval) {
                return $builder->withoutApproval();
            }
            return $builder->withoutGlobalScope($this);
        });
    }
    
    /**
     * Add the without-approved extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
     
    protected function addWithoutApproval(Builder $builder)
    {
        $builder->macro('withoutApproval', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedApprovedAtColumn()
            );
            return $builder;
        });
    }
    
    /**
     * Add the only-approval extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
     
    protected function addOnlyApproved(Builder $builder)
    {
        $builder->macro('onlyApproved', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedApprovedAtColumn()
            );
            return $builder;
        });
    }
}