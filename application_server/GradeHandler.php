<?php
class GradeHandler {

    public function get() {
        if ($_SESSION['account_type'] === 'instructor') {
            $instructor = $_SESSION['user_id'];
            $url = "http://web.njit.edu/~arm32/data_server/app.php/grade?instructor=$instructor";

            $code = 0;

            $result = MyGet($url, $code);

            if ($code === "200") {
                die($result);
            }else {
                http_response_code(400);
                die(json_encode(array(
                    "status" => "error",
                    "message" => "",
                )));
            }
            
        }else {
                // not implemented yet
            $student = $_SESSION['user_id'];
            $url = "http://web.njit.edu/~arm32/data_server/app.php/grade/$student";

            $code = 0;

            $result = MyGet($url, $code);
            $result = json_decode($result,true);
            
            if ($code === "200") {
                die(json_encode($result));
            }else {
                http_response_code(400);
                die(json_encode(array(
                    "status" => "error",
                    "message" => "",
                )));
            }
            
        }
    }
    public function post() {
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $id = $data['exam_id'];
        $url = "http://web.njit.edu/~arm32/data_server/app.php/exam/$id";

        $code = 0;

        $result = MyGet($url, $code);


        if($code === "200") {

            $correct_exam = json_decode($result,true);
            $graded = array();
            $score = 0;
            $total = 0;
            $graded['taken_at'] = date('Y-m-d H:i:s');
            $graded['exam_id'] = $data['exam_id'];
            $graded['answers'] = array();
            $user_answers = $data['answers'];
            $uid = $_SESSION["user_id"];
            $graded['student'] = $uid;
            $questions = $correct_exam['questions'];
            $correct_answers = array();
            foreach ($questions as $question) {
                $total += (int)$question['weight'];

                $coding_question = array();
                $qid = $question['id'];
                foreach($question['answers'] as $answer) {
                    // gather the coding answers into one array
                    if (strcmp($question['qtype'], "coding") === 0) {
                        $coding_question[$answer['answer_key']] = $answer['answer_value'];
                    }else {
                        if (strcmp($answer['correct'],"1") === 0) {
                            if (strcmp($user_answers[$qid]['value'],$answer['answer_value']) === 0) {
                                $score += (int)$question['weight'];
                                $graded['answers'][] = array(
                                        "qid" => $qid,
                                        "value" => $user_answers[$qid]['value'],
                                        "correct_answer" => $answer['answer_value'],
                                        "correct" => true,
                                        );

                            }else {
                                $graded['answers'][] = array(
                                        "qid" => $qid,
                                        "value" => $user_answers[$qid]['value'],
                                        "correct_answer" => $answer['answer_value'],
                                        "correct" => false,
                                        );
                            }
                        }
                    }
                }

                // now it's time to process coding questions
                // use out and err to provide feedback
                if (count($coding_question) > 0) {
                    $data = array(
                            "language" => $question['language'],
                            "content" => $user_answers[$qid]['value'],
                            "test_cases" => $coding_question,
                            );
                    $out;
                    $err;
                    if ( $this->grade_script($data, $out, $err)) {
                        $graded['answers'][] = array(
                                "qid" => $qid,
                                "value" => implode("\r\n",$out). "\r\n$err",
                                "correct_answer" => implode("\r\n",array_values($coding_question)),
                                "value" => implode("\r\n",$out). "\r\nERR: $err",
                                "correct_answer" => implode("\r\n",array_values($coding_question)),
                                "correct" => true,
                                );
                        $score += (int)$question['weight'];
                    }else {
                        $graded['answers'][] = array(
                                "qid" => $qid,
                                "value" => implode("\r\n",$out). "\r\nERR: $err",
                                "correct_answer" => implode("\r\n",array_values($coding_question)),
                                "correct" => false,
                                );
                    }
                }
            }

            $graded['total'] = $total;
            $graded['score'] = $score;

            $ch = curl_init();
            $url = "http://web.njit.edu/~arm32/data_server/app.php/grade";
            $data_string = json_encode($graded);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);

            $res = json_decode($result,true);
            $code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            die(json_encode(array(
                            "status" => "success",
                            "message" => "Your exam has been graded",
                            )));

        }else {
            die(json_encode(array(
                            "status" => "error",
                            "message" => "Grading Failed",
                            )));
        }
    }

    private function grade_script($data, &$out, &$err) {

        $MAX_FILE_LEN = 10000;
        $language = $data['language'];
        $content = $data['content'];

        $correct = $data['test_cases'];

        $input = array_keys($correct);
        $correct_output = array_values($correct);

        $cmd = "/usr/local/bin/python3.4.0a1 ";

        $inputFile = tempnam("/tmp", "codequizInput");
        $scriptFile = tempnam("/tmp", "codequizScript");
        $stdoutFile = tempnam("/tmp", "codequizOut");
        $stderrFile = tempnam("/tmp", "codequizErr");

        $scriptHandle = fopen($scriptFile,'w');
        fwrite($scriptHandle, $content, $MAX_FILE_LEN);
        fclose($scriptHandle);

        $inputHandle = fopen($inputFile, "w");
        fwrite($inputHandle, implode("\n", array_keys($correct)), $MAX_FILE_LEN);
        fclose($inputHandle);

        $cmd .= "$scriptFile < $inputFile > $stdoutFile 2> $stderrFile";
        exec($cmd);
        //passthru($cmd);    // so unsafe it's not even funny
        //exec('ls -lart',$out);
        
        $out_lines = file($stdoutFile, FILE_IGNORE_NEW_LINES);
        $out = $out_lines;
        $err = file_get_contents($stderrFile);

        unlink($inputFile);
        unlink($scriptFile);
        unlink($stdoutFile);
        unlink($stderrFile);

        return $correct_output === $out_lines;
    }

    public function patch() {
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $url = "http://web.njit.edu/~arm32/data_server/app.php/grade";
        $curl = curl_init($url);
        $content = json_encode(array(
            "instructor" => $_SESSION['user_id'],
            "exam" => $data['exam'],
            "student" => $data['student'],
            "taken_at" => $data['taken_at'],
        ));

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-type: application/json",
        ));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
 
        $response = curl_exec($curl);
 
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status === 200) {
            die(json_encode(array(
                "status" => "success",
                "message" => "released code",
            )));
        }else {
            http_response_code(400);
            die(json_encode(array(
                "status" => "error",
                "message" => "something went wrong",
            )));
        }

    }

}

?>
