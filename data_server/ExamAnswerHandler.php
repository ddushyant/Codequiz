<?php
class ExamAnswerHandler {

    public function get() {
        $student = $_GET['student'];
        $exam = $_GET['exam'];
        $taken_at = $_GET['taken_at'];

        $query_text = "
            SELECT q.spec, q.feedback, ea.correct, ea.answer, ea.correct_answer
            FROM (SELECT * FROM examanswer WHERE exam=:exam AND student=:student AND taken_at=:taken_at) AS ea
            JOIN question q ON q.id = ea.question;
        ";

        try {
            $conn = MySQL::getInstance();
            $conn->beginTransaction();

            $query = $conn
                    ->prepare($query_text);
            $query->bindValue(":exam", $exam, PDO::PARAM_INT);
            $query->bindValue(":student", $student, PDO::PARAM_INT);
            $query->bindValue(":taken_at", $taken_at, PDO::PARAM_STR);
            $query->execute();
            $examanswers = $query->fetchAll(PDO::FETCH_ASSOC);
            $conn->commit();

            die(json_encode(array(
                "status" => "success",
                "message" => "",
                "examanswers" => $examanswers,
            )));

        } catch (PDOException $e) {
            die(json_response(array(
                "status" => "error",
                "message" => $e->getMessage(),
            )));
        }
    }
}
?>
