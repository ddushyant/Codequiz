<?php

class QuestionHandler {


    public function post() {
        
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);


        $title    = $data['title'];
        $spec     = $data['spec'];  
        $language = $data['language'];
        $subject  = $data['subject'];
        $qtype    = $data['qtype'];

        $answers  = $data['answers'];

        $response = array();


        /*
           For coding, multiple-choice, or true-false questions,
           answers will be key-value pairs

           For open-ended, the answers will just be short strings
         */

        try {

            $conn = MySQL::getInstance();

            $query = $conn
                ->prepare(
                    "INSERT INTO question (title, spec, subject, language, qtype)
                     VALUES(:title,:spec,(SELECT id FROM subject WHERE name=:subject),(SELECT id FROM language WHERE name=:language),:qtype);
                    "
                );
            $query->bindValue(':title',   $title, PDO::PARAM_STR);
            $query->bindValue(':spec',    $spec, PDO::PARAM_STR);
            $query->bindValue(':language', $language, PDO::PARAM_STR);
            $query->bindValue(':subject', $subject, PDO::PARAM_STR);
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

            $response['question_id'] = $question_id;

       } catch (PDOException $e) {


           $err = array(
                "status" => "error",
                "message" => $e->getMessage()
           );

           die(json_encode($err));
       }

       http_response_code(201);

       $response['status'] = "success";
       $response['message'] = "";

       die(json_encode($response));
       
    }
}


?>
