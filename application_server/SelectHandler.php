<?php
class SelectHandler{
    public function get(){
        
        $language_data = array();
        $subject_data = array();            
        $success1 = $this->get_subject_data($subject_data);
        $success2 = $this->get_language_data($language_data);

        if($success1 && $success2){
            
            http_response_code(200);

            die(json_encode(array(
                "languages" => $language_data,
                "subjects" => $subject_data,
                "messages" => "Sent language and subject data",
                "status" => "success",
           )));
        }else{
            
            die(json_encode(array(
                "message" => "Failed to send language and subject data",
                "status" => "error",
            )));
        }
    }
	private function get_subject_data(&$data) {
		$url = "http://web.njit.edu/~arm32/data_server/app.php/subject";
		

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
        ));

        $result = curl_exec($ch);
        $tmp = json_decode($result,true);
        $data = $tmp['languages'];

        $code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $data = $tmp['subjects'];
       
		return $code === "200";
	}

	private function get_language_data(&$data) {
		$url = "http://web.njit.edu/~arm32/data_server/app.php/language";
		
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
        ));

        $result = curl_exec($ch);

        $code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

		$tmp = json_decode($result,true);
		$data = $tmp['languages'];

		return $code === "200";
	}
}
?>
