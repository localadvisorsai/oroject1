<?php

namespace App\Traits;

trait RequiresApproval
{ 
    /**
     * Boot the approved trait for a model.
     *
     * @return void
     */
    public static function bootApproved()
    {
        static::addGlobalScope(new ApprovedScope);
    }
    
    /**
     * Perform the actual approved query on this model instance.
     *
     * @return mixed
     */
    protected function performApprovalOnModel()
    {
        return $this->runApproved();
    }
    /**
     * Perform the actual approved query on this model instance.
     *
     * @return void
     */
     
    protected function runApproved()
    {
        $query = $this->newModelQuery()->where($this->getKeyName(), $this->getKey());
        $time = $this->freshTimestamp();
        $columns = [$this->getApprovedAtColumn() => $this->fromDateTime($time)];
        $this->{$this->getApprovedAtColumn()} = $time;
        if ($this->timestamps && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;
            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }
        $query->update($columns);
    }
    
    
    /**
     * Determine if the model instance has been approved.
     *
     * @return bool
     */
     
    public function approved()
    {
        return ! is_null($this->{$this->getApprovedAtColumn()});
    }

    /**
     * Get the name of the "approved at" column.
     *
     * @return string
     */
    public function getApprovedAtColumn()
    {
        return defined('static::APPROVED_AT') ? static::APPROVED_AT : 'approved_at';
    }
    
    /**
     * Get the fully qualified "approved at" column.
     *
     * @return string
     */
    public function getQualifiedApprovedAtColumn()
    {
        return $this->qualifyColumn($this->getApprovedAtColumn());
    }
}