<?php

/*
    MySQL singleton
*/
class MySQL {
    private static $instance = NULL;

    private function __construct() { }
    private function __clone() { }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new PDO(
                'mysql:host=localhost;dbname=codequiz', 
                'codequiz', 
                'foobar',
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        return self::$instance;
    }
}
