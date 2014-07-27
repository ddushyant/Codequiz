<?php
class GradeHandler {
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
            $graded['exam_id'] = $data['exam_id'];
            $graded['answers'] = array();
            $user_answers = $data['answers'];

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
                                "value" => $out,
                                "correct_answer" => array_values($coding_question),
                                "error" => $err,
                                "correct" => true,
                            );
                        $score += (int)$question['weight'];
                    }else {
                            $graded['answers'][] = array(
                                "qid" => $qid,
                                "value" => $out,
                                "correct_answer" => array_values($coding_question),
                                "error" => $err,
                                "correct" => false,
                            );
                    }
                }
            }
        
            $graded['total'] = $total;
            $graded['score'] = $score;
            die(json_encode($graded));
        }else {
            die(json_encode(array(
                "status" => "error",
                "message" => "Exam getting failed",
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

        $cmd = "";

        switch ($language) {
            case "Python":
                $cmd .= "python3 ";
                break;
            case "js":
                $cmd .= "node ";
                break;
            default:
                return false;
        }

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

        exec($cmd);    // so unsafe it's not even funny

        $out_lines = file($stdoutFile, FILE_IGNORE_NEW_LINES);
        $out = $out_lines;
        $err = file_get_contents($stderrFile);

        unlink($inputFile);
        unlink($scriptFile);
        unlink($stdoutFile);
        unlink($stderrFile);

        return $correct_output === $out_lines;
    }
    
}

?>
