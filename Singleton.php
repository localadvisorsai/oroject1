<?php

namespace App\Traits;

/**
 * Define a reusable singleton trait.
 */

trait Singleton {
     /**
     * Store the singleton object.
     */
    private static $singleton = null;

    /**
     * Fetch an instance of the class.
     */
    public static function getInstance() {
        if (self::$singleton === null) {
            self::$singleton = self::__instance();
        }

        return self::$singleton;
    }
}
