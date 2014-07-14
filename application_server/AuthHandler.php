<?php
class AuthHandler {
	public function post() {

		$username = $_POST['user'];
		$password = $_POST['pass'];      
		$is_external = $_POST['njit'] === "true";    // boolean to auth against NJIT or CodeQuiz Backend
		$logged_in = false;

		if ($is_external) {
			$username = str_replace("@njit.edu", "", $username);
			$logged_in = $this -> njit_login($username, $password);
			if ($logged_in) {
				echo '{"message":"Logged in using NJIT credentials"}';
			} else {
				echo '{"message":"NJIT Login Failed"}';
			}
		}else {
			$logged_in = $this -> backend_login($username, $password);
			if ($logged_in) {
			echo '{"message":"Logged in using CodeQuiz credentials"}';
			} else {
			echo '{"message":"CodeQuiz Login Failed"}';
			}
		}

		

	}

	private function njit_login($user, $pass){
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

	private function backend_login($username, $password) {
		header('Content-Type: application/json');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://web.njit.edu/~arm32/data_server/app.php/user/auth");
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
}



?>
