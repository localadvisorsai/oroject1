<?php

namespace App\Traits;

trait AdditionalFields
{
  protected $aggregate = 'additional_fields';

  public function accessAttribute($key)
  {
    $additional_fields = $this->__get($this->aggregate);
    if (isset($additional_fields[$key])) {
      return $additional_fields[$key];
    } else {
      return null;
    }
  }

  public function appendAttribute($value)
  {
    if ($value != null) {
      $additional_fields = $this->__get($this->aggregate);
      if (is_array($additional_fields)) {
        $this->__set($this->aggregate, array_merge($additional_fields, $value));
      } else {
        $this->__set($this->aggregate, $value);
      }
    }
  }
}
