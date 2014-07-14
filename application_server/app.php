<?php

require("../lib/Toro.php");
require('AuthHandler.php');
require('RegistrationHandler.php');

Toro::serve(array(
	"/auth" => "AuthHandler",
	"/register" => "RegisterHandler",
));

?>
