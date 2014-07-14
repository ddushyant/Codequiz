<?php

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
