<?php

class QuestionMakerHandler{

	function __construct(){
		ToroHook::add("before_handler", function() { 
			if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true){
				//Do Nothing
			}else{
				http_response_code(401);

				$response = array(
					"status" => "error",
					"message" => "no session found"
				);

				die(json_encode($response));
			}

		});
	}

	public function post() {
		/*
			Do Some Security Nonsense Later
		*/

		$data = file_get_contents("php://input");
		$data =strip_tags($data);

		$success = $this -> send_question_data($data);

		if ($success){
		
				http_response_code(200);

				$response = array(
					"status" => "success",
					"message" => "question creation succeeded"
				);

				die(json_encode($response));
		}else{
			http_response_code(400);

				$response = array(
					"status" => "error",
					"message" => "question creation failed"
				);

				die(json_encode($response));
		}
	}


	private function send_question_data($data) {
		$url = "http://web.njit.edu/~arm32/data_server/app.php/question";
		
		$code = 0;

		MyPost($url, $code, $data);

		return $code === "201";
	}
}
?>