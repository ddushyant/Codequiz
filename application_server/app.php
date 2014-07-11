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

function backend_login($username, $password) {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://localhost:4000/app.php/user/auth");
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
		"username" => $username,
		"password" => $password,
	)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);

    $code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);

	return $code === "204";
}

function send_register_data($username, $password) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://localhost:4000/app.php/user/register");
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
		"username" => $username,
		"password" => $password,
	)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);

    echo $result;
	return strpos($result, "301") !== false;
}


class AuthHandler {
	public function post() {

        header("Access-Control-Allow-Origin: *");

		$username = $_POST['user'];
		$password = $_POST['pass'];      
		$is_external = $_POST['njit'] === "true";    // boolean to auth against NJIT or CodeQuiz Backend
		$logged_in = false;

		if ($is_external) {
			$username = str_replace("@njit.edu", "", $username);
			$logged_in = njit_login($username, $password);
		}else {
			$logged_in = backend_login($username, $password);
		}
		
        header('Content-Type: application/json');
		if ($logged_in) {
			echo '{"message":"YES"}';
        } else {
			echo '{"message":"NO"}';
        }

	}
}

class RegisterHandler{
	public function post() {

		$success = false;

		$username = $_POST['user'];
		$password = $_POST['pass'];


		$success = send_register_data($username, $password);

		header('Content-Type: application/json');
 		header("Access-Control-Allow-Origin: *");
		if ($success){
		}else{
		}

	}
}

Toro::serve(array(
	"/auth" => "AuthHandler",
    "/register" => "RegisterHandler",
));
