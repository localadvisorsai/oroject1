<?php


namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

/**
 * This trait includes methods that interface with Redis hashes, which are data maps. These hashes are a good way to
 * temporarily cache data being used throughout a process. They are user-specific with the hash key being
 * Auth::user()->id. The hash value is what is referred to as an instance, which should be a unique identifier that is
 * created when the process begins and destroyed when the process ends. If the engineer is sloppy (George) and doesn't
 * destroy the instance at the end of the process, the cache is automatically cleaned up later when the session ends,
 * which destroy's the user-specific hash altogether. Note the instance is what allows a user to cache data that is
 * specific to a process, so if you need two processes to collide, these instances are a good way of sharing data
 * between the two.
 */
trait CachedHash {

    /**
     * Retrieves cached instance data from Redis. Note the data is stored in Redis as a json string and is converted
     * to an associative array for use in PHP. That means when you send an object in, it will come back out as array,
     * which you need to keep in mind when coding your blades.
     *
     * @param  string  $instance //uniqid()
     * @return array //associative
     */
    public function getCachedHash($instance) {
        return json_decode(Redis::hget(Auth::User()->id, $instance), true);
    }

    /**
     * Retrieves the data of a particular hash field
     *
     * @param  string  $instance //uniqid()
     * @param  string  $field_name
     * @return array //associative
     */
    public function getCachedHashField($instance, $field_name) {
        $cache = $this->getCachedHash($instance);
        return (isset($cache[$field_name])) ? $cache[$field_name] : NULL;
    }

    /**
     * Creates a hash field with its data. If the field already exists, previous data will be overwritten.
     *
     * @param  string  $instance    //uniqid()
     * @param  string  $field_name
     * @param  string | int | array | object $data //will take anything since it's getting converted to json.
     * @return array //associative
     */
    public function setCachedHashField($instance, $field_name, $data) {
        $cache = $this->getCachedHash($instance);
        $cache[$field_name] = $data;
        Redis::hset(Auth::User()->id, $instance, json_encode($cache));
    }
}
