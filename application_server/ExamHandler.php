<?php
Class ExamHandler{

    public function get($id) {
        if (! is_null($id) ) {
            $url = "http://web.njit.edu/~arm32/data_server/app.php/exam/$id";
            
            $code = 0;

            $result = MyGet($url, $code);

            if($code === "200") {
                die($result);
            }else {
                die(json_encode(array(
                    "status" => "error",
                    "message" => "Exam getting failed",
                )));
            }
        }else {
            $n = isset($_GET['n']) ? $_GET['n'] : '20';
            $url = "http://web.njit.edu/~arm32/data_server/app.php/exam?n=$n";
            
            $code = 0;

            $result = MyGet($url, $code);

            if($code === "200") {
                die($result);
            }else {
                die(json_encode(array(
                    "status" => "error",
                    "message" => "listing exams failed",
                )));
            }
        }
    }
    public function post(){
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $uid = $_SESSION['user_id'];
        $data['instructor'] = $uid;


	    $ch = curl_init();
		$url = "http://web.njit.edu/~arm32/data_server/app.php/exam";
		$data_string = json_encode($data);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       
        $result = curl_exec($ch);
        
        $res = json_decode($result,true);
        $code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);        
		curl_close($ch);         

        $success = $code === "201";
 
        if($success){
            http_response_code(200);
			die(json_encode(array(
                "status" => "success",
                "message" => "created exam",
                "exam_id" => $res['exam_id']
            )));
        }else {
            http_response_code(400);
			die(json_encode(array(
                "status" => "success",
                "message" => "could not make exam"
            )));
        }

    }
}
