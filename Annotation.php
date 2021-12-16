<?php

namespace App\Traits;

trait Annotation
{
    use AdditionalFields;

    /*
	/--------------------------------------------------------------------------
	/ Accessors
	/--------------------------------------------------------------------------
	*/

     public function getNotesAttribute() {
     	return $this->accessAttribute('notes');
     }

    /*
    /--------------------------------------------------------------------------
    / Mutators
    /--------------------------------------------------------------------------
    */

    public function setNotesAttribute($value) {
    	$this->appendAttribute(["notes.body" => $value]);
    }
}