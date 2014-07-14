<?php
$DATA_SERVER_BASE_URL = $_ENV["DATA_SERVER_BASE_URL"];

require("../lib/Toro.php");
require('AuthHandler.php');
require('RegistrationHandler.php');

Toro::serve(array(
	"/auth" => "AuthHandler",
	"/register" => "RegisterHandler",
));

?>
