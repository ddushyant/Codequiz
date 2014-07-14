<?php
class RegisterHandler{
	public function post() {

		$success = false;

		$username = $_POST['user'];
		$password = $_POST['pass'];
		$account_type = isset($_POST['account_type']) ? $_POST['account_type'] : 'student';


		$success = $this -> send_register_data($username, $password, $account_type);

		if ($success){
			echo "{\"message\":\"success\"}";
		}else{
			echo "{\"message\":\"failure\"}";
		}

	}
	private function send_register_data($username, $password, $type) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"$DATA_SERVER_BASE_URL/user/register");
		curl_setopt($ch, CURLOPT_HEADER  , true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
			"username" => $username,
			"password" => $password,
			"account_type" => $type
			)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $code === "201";
	}
}
?>