<?php

class RegisterHandler{
	public function post() {

		$success = false;
		$data = file_get_contents("php://input");
		$data = json_decode($data,true);

		$username = $data['user'];
		$password = $data['pass'];
		$account_type = isset($data['account_type']) ? $data['account_type'] : 'student';

		$params = array(
			"username" => $username,
			"password" => $password,
			"account_type" => $account_type
		);

        $params = json_encode($params);
		$code = 0;
		$url = "http://web.njit.edu/~arm32/data_server/app.php/user/register";
		$result = MyPost($url,$code,$params);

        $result = json_decode($result,true);
		$success = $result['status'] === 'success';
		if ($success){
			echo "{\"message\":\"success\"}";
		}else{
			echo "{\"message\":\"failure\"}";
		}

	}
}
?>
