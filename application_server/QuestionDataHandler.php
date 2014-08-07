<?php

class QuestionDataHandler{
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

	public function get() {
		/*
			Do Some Security Nonsense Later
		*/
		$n = isset($_GET['n']) ? $_GET['n'] : '20';   // number of questions to retrieve

		$questions = array();
		$languages = array();
		$subjects = array();

		$success1 = $this -> get_question_data($questions, $n);
		$success2 = $this -> get_language_data($languages);
		$success3 = $this -> get_subject_data($subjects);

		if ($success1 && $success2 && $success3){
		
				http_response_code(200);

				$response = array(
					"status" => "success",
					"message" => "",
					"questions" => $questions,
					"languages" => $languages,
					"subjects" => $subjects
				);

				die(json_encode($response));
		}else{
			http_response_code(400);

				$response = array(
					"status" => "error",
					"message" => "Could Not Retrieve Exam Questions"
				);

				die(json_encode($response));
		}
	}


	private function get_question_data(&$data,$n) {
		$url = "http://web.njit.edu/~arm32/data_server/app.php/question";
		
		$code = 0;

		$tmp = json_decode(MyGet($url, $code),true);
		$data = $tmp['questions'];

		return $code === "200";
	}

	private function get_subject_data(&$data) {
		$url = "http://web.njit.edu/~arm32/data_server/app.php/subject";
		
		$code = 0;

		$tmp = json_decode(MyGet($url, $code),true);
		$data = $tmp['subjects'];

		return $code === "200";
	}

	private function get_language_data(&$data) {
		$url = "http://web.njit.edu/~arm32/data_server/app.php/language";
		
		$code = 0;

		$tmp = json_decode(MyGet($url, $code),true);
		$data = $tmp['languages'];

		return $code === "200";
	}
}
?>
