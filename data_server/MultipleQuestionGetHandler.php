<?php
class MultipleQuestionGetHandler {
    public function get($author) {
        try {
            $query = MySQL::getInstance()
                   ->query(
                        "SELECT (title,spec,author,subject,qtype)
                         FROM question
                         WHERE author = :author;
                        "
                    );
            $query->bindValue(":author", $uid, PDO::PARAM_STR);
            $query->execute();

            $questions = $query->fetchAll(PDO::FETCH_ASSOC);

            $response = array(
                "status"    => "success",
                "message"   => "",
                "questions" => $questions,
            );

            die(json_encode($response));

        } catch (PDOException $e) {
            http_response_code(500);
            $response = array(
                "status"    => "error",
                "message"   => $e->getMessage(),
            );
            die(json_encode($response));
        }
    }
}
?>
