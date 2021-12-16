<?php

namespace App\Traits;

trait Analytics
{  use AdditionalFields;


    public function getClicksAttribute($key='clicks',$months=3) {
    $stats = $this->accessAttribute($key);
    $month_stats = array_splice($stats,$months);
    return array_sum($month_stats);
}

    /*
	/--------------------------------------------------------------------------
	/ Accessors
	/--------------------------------------------------------------------------
	*/

     public function getStatsAttribute() {
     	return $this->accessAttribute('stats');
     }
    /*
    /--------------------------------------------------------------------------
    / Mutators
    /--------------------------------------------------------------------------
    */

    public function setStatsAttribute($value) {
    	$this->appendAttribute(["stats" => $value]);
    }
}
