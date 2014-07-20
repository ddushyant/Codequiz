<?php

require('post_helper.php');

class QuestionMakerHandler{

	public function post() {
		/*
			Do Some Security Nonsense Later
		*/
		$title 		= $_POST['title'];
		$body 		= $_POST['body'];
		$language 	= $_POST['language'];
		$subject  	= $_POST['subject'];
		$qtype 		= $_POST['qtype'];
		$answers 	= $_POST['answers'];

		$success = $this -> send_question_data($title, $body, $language, $subject, $qtype, $answers);

		if ($success){
			echo "{\"message\":\"success\"}";
		}else{
			echo "{\"message\":\"failure\"}";
		}
	}


	private function send_question_data($title, $body, $language, $subject, $qtype, $answers) {
		$url = "http://web.njit.edu/~arm32/data_server/app.php/question";

		$data = array(
			"title" => $title,
			"spec" => $body,
			"subject" => $subject,
			"qtype" => $qtype,
			"answers" => $answers
		);
		
		$code = null;

		Post($url, &$code, $data);

		return $code === "201";
	}
}
?>