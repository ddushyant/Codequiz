<?php

require("../lib/Toro.php");
require('AuthHandler.php');
require('RegistrationHandler.php');
require('QuestionMakerHandler.php');
require('ExamMakerHandler.php');

Toro::serve(array(
	"/auth" => "AuthHandler",
	"/register" => "RegisterHandler",
	"/questionmaker" => "QuestionMakerHandler",
	"/exammaker" => "ExamMakerHandler",
));

?>
