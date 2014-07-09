<?php

require("../lib/Toro.php");

function njit_login($user, $pass){
	// user=UCID&pass=pass&uuid=0xACA021
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://cp4.njit.edu/cp/home/login");
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
	"user" => $user,
	"pass" => $pass,
	"uuid" => "0xACA021"
	)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	 
	// Logout to kill any sessions
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://cp4.njit.edu/up/Logout?uP_tparam=frm&frm=");
	curl_exec($ch);
	curl_close($ch);
	 
	// Return validation bool
	return strpos($result, "loginok.html") !== false;
}

function backend_login() {

}


class AuthHandler {
	public function post() {

		$username = $_POST['user'];
		$password = $_POST['pass'];       // should be hashing this with bcrypt or something
		$is_external = $_POST['njit'] === "true";    // boolean to auth against NJIT or CodeQuiz Backend
		$logged_in = false;

		if ($is_external) {
			$username = str_replace("@njit.edu", "", $username);
			$logged_in = njit_login($username, $password);
		}else {
			$logged_in = backend_login($username, $password);
		}
		
		if ($logged_in) echo "LOGGED";
		else echo "NOOOO";

	}
}


Toro::serve(array(
	"/auth" => "AuthHandler",
));