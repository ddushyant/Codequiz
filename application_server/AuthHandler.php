<?php
class AuthHandler {
	public function post() {

		$data = file_get_contents("php://input");
		$clean_data = strip_tags($data);
		$data = json_decode($clean_data, true);

		$username = $data['user'];
		$password = $data['pass'];      
		$is_external = $data['njit'] === "true";    // boolean to auth against NJIT or CodeQuiz Backend
		$logged_in = false;

		if ($is_external) {

			$username = str_replace("@njit.edu", "", $username);
			$logged_in = $this -> njit_login($username, $password);

			if ($logged_in) {
				
				$_SESSION["logged_in"] = true;

				http_response_code(200);

				$response = array(
					"status" => "success",
					"message" => "Logged in using NJIT credentials"
				);

				die(json_encode($response));

			} else {

				http_response_code(401);

				$response = array(
					"status" => "error",
					"message" => "NJIT Login Failed"
				);

				die(json_encode($response));
			}
		}else {

			$logged_in = $this -> backend_login($clean_data);
			if ($logged_in) {
			
				$_SESSION["logged_in"] = true;

				http_response_code(200);

				$response = array(
					"status" => "success",
					"message" => "Logged in using CodeQuiz credentials"
				);

				die(json_encode($response));

			} else {
				http_response_code(401);

				$response = array(
					"status" => "error",
					"message" => "CodeQuiz Login Failed"
				);

				die(json_encode($response));
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

	private function backend_login($data) {
		

		$url = "http://web.njit.edu/~arm32/data_server/app.php/user/auth";
		$code = 0;

		MyPost($url, $code, $data);

		return $code === "204";
	}
}



?>
