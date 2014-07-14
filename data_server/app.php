<?php

$DB_SERVER_URL  = $_ENV['DB_SERVER_URL'];
$DB_USER        = $_ENV['DB_USER'];
$DB_PASSWORD    = $_ENV['DB_PASSWORD'];

require('../lib/Toro.php');
require('ExistHandler.php');
require('AuthHandler.php');
require('RegistrationHandler.php');
require('../lib/hash.php');
require('sql_helper.php');


Toro::serve(array(
    "/user/auth" => "AuthHandler",
    "/user/register" => "RegistrationHandler",
    "/user/exist" => "ExistHandler",
    "/question" => "QuestionCreateHandler",
    "/question/:number" => "QuestionGetHandler",
));

?>
