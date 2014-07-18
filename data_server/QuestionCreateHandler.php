<?php

class QuestionCreateHandler {

    private function translate_answer_key($k) {
        switch($k) {
            case '0': return 'A';
            case '1': return 'B';
            case '2': return 'C';
            case '3': return 'D';
            default:  return 'A';
        }
    }

    public function post() {
        header("Content-type: application/json");

        
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);


        $title    = $data['title'];
        $spec     = $data['spec'];  
        $subject  = $data['subject'];
        $qtype    = $data['qtype'];

        $answers  = $data['answers'];




        /*
           For coding, multiple-choice, or true-false questions,
           answers will be key-value pairs

           For open-ended, the answers will just be short strings
         */

        try {

            $conn = MySQL::getInstance();

            $query = $conn
                ->prepare(
                    "INSERT INTO question (title, spec, subject, qtype)
                     VALUES(:title,:spec,:subject,:qtype);
                    "
                );
            $query->bindValue(':title',   $spec, PDO::PARAM_STR);
            $query->bindValue(':spec',    $spec, PDO::PARAM_STR);
            $query->bindValue(':subject', $subject, PDO::PARAM_INT);
            $query->bindValue(':qtype',   $qtype, PDO::PARAM_STR);

            /* BEGIN question create transaction */
            $conn->beginTransaction();


            $query->execute();

            $question_id = $conn->lastInsertId();

            $query2_text = "INSERT INTO answer (question, answer_key, answer_value, correct) VALUES ";

            /*
                SQL requires INSERTS to have the format: VALUES (...),(...),(...)
                With NO trailing commas
            */
            $params = array();

            foreach ($answers as $a) {

                $a['answer_key'] = $this->translate_answer_key($a['answer_key']);

                $query2_text .= '(';
                $params[] = $question_id;
                $query2_text .= '?,';
                foreach ($a as $v) {
                    $params[] = $v;
                    $query2_text .= '?,';
                }

                $query2_text = rtrim($query2_text, ",");
                $query2_text .= '),';
            }


            $query2_text = rtrim($query2_text, ",");

            $query2 = $conn->prepare($query2_text);
            $query2->execute($params);
            

            /* END question CREATE transaction */
            $conn->commit();

       } catch (PDOException $e) {


           $err = array(
                "status" => "error",
                "message" => $e->getMessage()
           );

           die(json_encode($err));
       }

       $response = array(
            "status" => "success",
            "message" => "",
       );
       http_response_code(201);
       die(json_encode($response));
       
    }
}


?>
