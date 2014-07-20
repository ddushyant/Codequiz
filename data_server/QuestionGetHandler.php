<?php
class QuestionGetHandler {
    public function get($qid) {

       try {
           $query = MySQL::getInstance()
                  ->prepare(
                    "SELECT title,spec,subject,qtype
                     FROM question
                     WHERE qid=:qid;
                    "
                   );
           $query->bindValue(":qid", $qid, PDO::PARAM_INT);

           $query->execute();

           $question = $query->fetch(PDO::FETCH_ASSOC);
           
           $response = array(
                "status"     => "",
                "message"    => "",
                "question"   => $question,
           );

           if ($query->rowCount > 0) {
               http_response_code(200);
               $response['status'] = "success";
           } else {
               http_response_code(404);
               $response['status'] = "error";
           }

           die(json_encode($response));

       } catch (PDOException $e) {

           http_response_code(500);
           $err = array(
                "status" => "error",
                "message" => $e->getMessage(),
           );

           die(json_encode($err));
       }
    }
}
?>
