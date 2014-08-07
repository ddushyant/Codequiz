<?php

class QuestionCreateHandler {


  public function get($qid) {
     $response = array(
          "status"     => "success",
          "message"    => "",
    );

    if (is_null($qid)) {
         //$start = isset($_GET["start"]) ? $_GET["start"] : 0;
         //$end = isset($_GET["end"]) ? $_GET["end"] : 20;

         $query_text =
                      "SELECT id,title,spec,subject,qtype
                      FROM question";

         $subject = $_GET["subject"];
         $difficulty = $_GET["difficulty"];
         $language = $_GET["language"];
         $qtype = $_GET["qtype"];

         if (!is_null($subject)) $params['subject'] = $subject;
         if (!is_null($difficulty)) $params['difficulty'] = $difficulty;
         if (!is_null($language)) $params['language'] = $language;
         if (!is_null($qtype)) $params['qtype'] = $qtype;

         $count = 0;

         foreach ($params as $k => $v) {
             if ($count > 0) {
                 $query_text .= " AND $k = :$k";
             }else {
                 $query_text .= " WHERE $k = :$k";
             }
             $count = $count + 1;
         }

         //$query_text .= " LIMIT :start,:end";

        try {
            $query = MySQL::getInstance()
                ->prepare($query_text);
            if (!is_null($subject)) $query -> bindValue(":subject", $subject, PDO::PARAM_INT); 
            if (!is_null($difficulty)) $query -> bindValue(":difficulty", $difficulty, PDO::PARAM_INT); 
            if (!is_null($language))  $query -> bindValue(":language", $language, PDO::PARAM_INT); 
             if (!is_null($qtype)) $query -> bindValue(":qtype", $qtype, PDO::PARAM_STR); 
                 
            //$query -> bindValue(":start", $start, PDO::PARAM_INT); 
            //$query -> bindValue(":end", $end, PDO::PARAM_INT); 

            $query->execute();

            $questions = $query->fetchAll(PDO::FETCH_ASSOC);

            $response['questions'] = $questions;
             

         } catch (PDOException $e) {

             http_response_code(500);
             $err = array(
                  "status" => "error",
                  "message" => $e->getMessage(),
             );

             die(json_encode($err));
         }

         die(json_encode($response));
    } else {
        try {
            // changes made: added join, answer_value, answer_key, a.correct=TRUE
             $query = MySQL::getInstance()
                    ->prepare(
                      "SELECT q.id,q.title,q.spec,q.subject,q.qtype, a.answer_value, a.answer_key
                       FROM question q
                       JOIN answer a ON q.id = a.question 
                       WHERE q.id=:qid
                       AND a.correct = TRUE;
                      "
                     );
             $query->bindValue(":qid", $qid, PDO::PARAM_INT);

             $query->execute();

             $question = $query->fetch(PDO::FETCH_ASSOC);

             $response['question'] = $question;
             
         } catch (PDOException $e) {

             http_response_code(500);
             $err = array(
                  "status" => "error",
                  "message" => $e->getMessage(),
             );

             die(json_encode($err));
         }

         $response['status'] = 'success';
         die(json_encode($response));
    }
  }

    public function post() {
        
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);


        $title    = $data['title'];
        $spec     = $data['spec'];  
        $language = $data['language'];
        $subject  = $data['subject'];
        $qtype    = $data['qtype'];
        $feedback = $data['feedback'];
        $difficulty = $data['difficulty'];
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
                    "INSERT INTO question (title, spec, subject, language, qtype, difficulty, feedback)
                     VALUES ( :title, :spec, :subject, :language, :qtype, :difficulty, :feedback );
                    "
                );
            $query->bindValue(':title',   $title, PDO::PARAM_STR);
            $query->bindValue(':spec',    $spec, PDO::PARAM_STR);
            $query->bindValue(':language', $language, PDO::PARAM_STR);
            $query->bindValue(':qtype',   $qtype, PDO::PARAM_STR);
            $query->bindValue(':subject', $subject, PDO::PARAM_STR);
            $query->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
            $query->bindValue(':feedback', $feedback, PDO::PARAM_STR);
            
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
       $response['message'] = "Question Created";

       die(json_encode($response));
       
    }
}


?>
