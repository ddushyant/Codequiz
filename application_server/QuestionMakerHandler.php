<?php

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
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://web.njit.edu/~arm32/data_server/app.php/question");
		curl_setopt($ch, CURLOPT_HEADER  , true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
			"title" => $title,
			"author" => "1",
			"spec" => $body,
			"language" => $language,
			"subject" => $subject,
			"qtype" => $qtype,
			"answers" => $answers
			)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $code === "201";
	}
}
?>