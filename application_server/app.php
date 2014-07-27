<?php

//session_save_path ('../../app_sessions');
session_start();
require("../lib/Toro.php");
require('AuthHandler.php');
require('RegistrationHandler.php');
//require('QuestionMakerHandler.php');
require('QuestionDataHandler.php');
require('post_helper.php');
require('get_helper.php');
require('UserInfoHandler.php');
require('ExamHandler.php');
require('GradeHandler.php');

Toro::serve(array(
	"/auth" => "AuthHandler",
	"/register" => "RegisterHandler",
	"/exammaker" => "ExamMakerHandler",
	"/question_data" => "QuestionDataHandler",
	"/user_info"    => "UserInfoHandler",
    "/exam"         => "ExamHandler",
    "/exam/:number" => "ExamHandler",
    "/grade"        => "GradeHandler",
));

?>
