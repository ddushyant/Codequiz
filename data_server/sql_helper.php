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
        try {
            self::$instance = new PDO(
                'mysql:host=sql.njit.edu;dbname=arm32;charset=utf8',
                '',
                '',
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true
                )
              );
        }catch (PDOException $e) {
          echo $e->getMessage();
        }
      }
        return self::$instance;
    }
}
