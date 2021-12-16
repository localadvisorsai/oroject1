<?php

namespace App\Traits;

trait Person
{


    /*
	/--------------------------------------------------------------------------
	/ Accessors
	/--------------------------------------------------------------------------
	*/

public function getFullNameAttribute()
{

	$full_name = '';
    	if (!is_null($this->prefix)) $full_name  = $this->prefix;
	if (!is_null($this->first_nm)) $full_name = $full_name.' '.$this->first_nm;
if (!is_null($this->last_nm)) $full_name = $full_name.' '.$this->last_nm;
	if (!is_null($this->suffix)) $full_name = $full_name.' '.$this->suffix;
    	return $full_name;
}

}
