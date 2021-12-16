<?php

namespace App\Traits;

/**
 * Define a reusable singleton model creaytion by name trait.
 */

trait ModelSingleton {
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

/**
     * Fetch an instance of the class.
     */
    public static function buildModel() {
        if (self::$singleton === null) {
           $modek_name = getModelName();
            self::$singleton = new $model_name;
        }

        return self::$singleton;
    }


/**
     * Fetch class name from object
     */
    public static function getClassName() {

        return self::$getClass($this);
    }
}


/**
     * Fetch model name from controller name
     */
    public static function getModelName(string $class_name) {
        return "App/".str_replace($class_name, "Conroller", "");
    }
}