<?php
class AuthHandler {
	public function post() {
		$data = file_get_contents("php://input");
		$data = json_decode($data,true);
		$username = $data['user'];
		$password = $data['pass'];      
		$is_external = isset($data['njit']) && $data['njit'] === "true";    // boolean to auth against NJIT or CodeQuiz Backend
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
			$ch = curl_init();
			$url = "http://web.njit.edu/~arm32/data_server/app.php/user/auth";
			$data_string = json_encode(array("username"=>$username,"password"=>$password));

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$result = curl_exec($ch);
			$code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);

			$logged_in = $code === "200";
			if ($logged_in) {
				$_SESSION['logged_in'] = true;
				$data = json_decode($result,true);
				$_SESSION['account_type'] = $data['account_type'];
                $_SESSION['user_id'] = $data['user_id'];
												
                $response = array(
                    "message" => "Logged in using CodeQuiz credentials",
                    "status" => "success",
                    "account_type" => $data['account_type'],
                );

                die(json_encode($response));

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
		$url = "http://web.njit.edu/~arm32/data_server/app.php/user/auth";

		$params = array(
			"username"=>$username,
			"password"=>$password
		);

		$code = 0;
		$result = MyPost($url,$code,$params);

		return $code === "204";
	}
}



?>
