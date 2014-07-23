<?php

require('../lib/Toro.php');
require('ExistHandler.php');
require('AuthHandler.php');
require('RegistrationHandler.php');
require('QuestionCreateHandler.php');
require('../lib/hash.php');
require('sql_helper.php');


Toro::serve(array(
    "/user/auth"                => "AuthHandler",
    "/user/register"            => "RegistrationHandler",
    "/user/exist"               => "ExistHandler",
    "/question/subject/:alpha"  => "QuestionGetHandler",
    "/question/language/:alpha" => "QuestionGetHandler",
    "/question/:number"         => "QuestionCreateHandler"
    "/exam/:number"             => "ExamHandler"
));

?>
