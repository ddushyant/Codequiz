<?php

require("../lib/Toro.php");
require('AuthHandler.php');
require('RegistrationHandler.php');
require('QuestionMakerHandler.php');

Toro::serve(array(
	"/auth" => "AuthHandler",
	"/register" => "RegisterHandler",
	"/questionmaker" => "QuestionMakerHandler",
));

?>
