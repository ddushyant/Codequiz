<?php

require('../lib/Toro.php');
require('ExistHandler.php');
require('AuthHandler.php');
require('RegistrationHandler.php');
require('../lib/hash.php');
require('sql_helper.php');

try {
    $db = new PDO(
        'mysql:host=localhost;dbname=codequiz;charset=utf8', 
        'codequiz', 
        'foobar', 
        array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
} catch (PDOException $e) {
    echo $e->getMessage();
}

Toro::serve(array(
    "/user/auth" => "AuthHandler",
    "/user/register" => "RegistrationHandler",
    "/user/exist" => "ExistHandler",
    "/question" => "QuestionCreateHandler",
    "/question/:number" => "QuestionGetHandler",
));

?>
