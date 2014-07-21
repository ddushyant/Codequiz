<?php


header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
session_start();
require("../lib/Toro.php");
require('AuthHandler.php');
require('RegistrationHandler.php');
require('QuestionMakerHandler.php');
require('post_helper.php');
//require('ExamMakerHandler.php');

Toro::serve(array(
	"/auth" => "AuthHandler",
	"/register" => "RegisterHandler",
	"/question" => "QuestionMakerHandler",
	"/exammaker" => "ExamMakerHandler",
));

?>
