<?php

class RegisterHandler{
	public function post() {

		$success = false;

		$data = file_get_contents("php://input");
		strip_tags($data);
		$data = json_decode($data, true);

		$username = $data['user'];
		$password = $data['pass'];
		$account_type = isset($data['account_type']) ? $data['account_type'] : 'student';


		$success = $this -> send_register_data($username, $password, $account_type);

		if ($success){
			$_SESSION["logged_in"] = true;
				http_response_code(200);

				$response = array(
					"status" => "success",
					"message" => "registration succeeded"
				);

				die(json_encode($response));
		}else{
			http_response_code(401);

			$response = array(
				"status" => "error",
				"message" => "registration failed"
			);

			die(json_encode($response));
		}

	}
	private function send_register_data($username, $password, $type) {

		$url = "http://web.njit.edu/~arm32/data_server/app.php/user/register";
		$code = 0;

		MyPost($url, $code, $data);

		return $code === "201";
	}
}
?>
