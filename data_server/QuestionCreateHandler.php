<?php

class QuestionCreateHandler {
    public function post() {
       $title   = $_POST['title'];
       $spec    = $_POST['spec'];  
       $author  = $_POST['author'];
       $subject = $_POST['subject'];
       $qtype   = $_POST['qtype'];
       
       $answers = $_POST['answers'];

       /*
        For coding, multiple-choice, or true-false questions,
        answers will be key-value pairs

        For open-ended, the answers will just be short strings
       */
       if ($qtype !== "open") {
           $answers = json_decode($answers);
       }

       try {
           $query = MySQL::getInstance()
                  ->prepare(
                    "INSERT INTO question (title,spec,author,subject,qtype)
                     VALUES(:title,:spec,:author,:subject,:qtype);
                    "
                  );
           $query->bindValue(':title', $spec, PDO::PARAM_STR);
           $query->bindValue(':spec', $spec, PDO::PARAM_STR);
           $query->bindValue(':author', $author, PDO::PARAM_INT);
           $query->bindValue(':subject', $subject, PDO::PARAM_INT);
           $query->bindValue(':qtype', $qtype, PDO::PARAM_STR);
           $query->execute();


       } catch (PDOException $e) {
           $err = array(
                "error" => $e->getMessage(),
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
