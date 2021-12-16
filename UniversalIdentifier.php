<?php
namespace App\Traits;
trait UniversalIdentifier {

    public static function findByUuid($uuid) {
        return parent::whereUUID($uuid)->first();
    }

    public function getUuidAttribute($value) {
        return bin2hex($value);
    }

    public function scopeWhereUuid($query, $uuid) {
        return $query->where('uuid', hex2bin($uuid));
    }
}
