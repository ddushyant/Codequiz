<?php

require('../lib/Toro.php');

Toro::serve(array(
    "/user/exists" => "ExistHandler",
    "/user/auth" => "AuthHandler",
    "/user/register" => "RegistrationHandler",
    "/question/create" => "QuestionCreateHandler",
    "/question/get" => "QuestionGetHandler",
    "/
));

?>
