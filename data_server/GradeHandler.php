<?php
class GradeHandler {
    public function get($student) {
        // /grade/:id
        if (!is_null($student)) {
            $results = array();
            $queryText = "
                SELECT e.id AS exam_id, e.title AS exam_title, g.taken_at, g.score, g.total
                FROM grade g
                JOIN exam e ON g.exam = e.id 
                WHERE g.student = :student
                AND g.released = TRUE
                ORDER BY g.taken_at ASC
                ";
            try {
                $conn = MySQL::getInstance();
                $query = $conn->prepare($queryText);
                $query->bindValue(":student", $student, PDO::PARAM_INT);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                http_response_code(500);
                die(json_encode(array(
                    "status" => "error",
                    "message" => "",
                )));
            }

            die(json_encode(array(
                "status" => "success",
                "message" => "",
                "grades" => $results,
            )));
        }else {    // /grade?param1=foo&param2=bar
            $instructor = $_GET["instructor"];

            $queryText = "
                SELECT g.student as student_id, u.username, e.id AS exam_id, e.title AS exam_title, g.taken_at, g.score, g.total
                FROM grade g
                JOIN exam e ON g.exam = e.id 
                JOIN codequizuser u ON g.student = u.id
                WHERE e.instructor = :instructor
                AND g.released = FALSE
                ";
            $pending_results = array();

            try{
                $conn = MySQL::getInstance();
                $conn->beginTransaction();
                $query = $conn->prepare($queryText);
                $query->bindValue(":instructor", $instructor, PDO::PARAM_INT);
                $query->execute();
                $pending_results = $query->fetchAll(PDO::FETCH_ASSOC);
                $conn->commit();
            } catch(PDOException $e){
                die(json_encode(array(
                    "status" => "error",
                    "message" => $e->getMessage(),
                )));
            }

            die(json_encode(array(
                "status" => "success",
                "pending_results" => $pending_results,
                "message" => "",
            )));
        }
    }

    public function post() {
        $data = file_get_contents("php://input"); 
        $data = json_decode($data,true);

        $student = $data['student'];
        $exam = $data['exam_id'];
        $score = $data['score'];
        $total = $data['total'];
        $taken_at = $data['taken_at'];

        $query1_text = "
            INSERT INTO grade (exam,student,taken_at,score,total,released)
            VALUES (:exam, :student, :taken_at, :score, :total, FALSE);
        ";

        $query2_text = "
            INSERT INTO examanswer (exam, student, question, taken_at, answer, correct_answer, correct)
            VALUES ";

        $params = array();

        foreach ($data['answers'] as $qid => $answer) {
            $query2_text .= '(?,?,?,?,?,?,?),';
            $params[] = $exam;
            $params[] = $student;
            $params[] = $answer['qid'];   // question
            $params[] = $taken_at;
            $params[] = $answer['value'];
            $params[] = $answer['correct_answer'];  // slight denormalization of table for ease
            $params[] = $answer['correct'];
        }

        $query2_text = rtrim($query2_text, ",") . ";";

        try {
            $conn = MySQL::getInstance();
            $conn->beginTransaction();
            $query = $conn->prepare($query1_text);
            $query->bindValue(":exam", $exam, PDO::PARAM_INT);
            $query->bindValue(":student", $student, PDO::PARAM_INT);
            $query->bindValue(":taken_at", $taken_at, PDO::PARAM_STR);
            $query->bindValue(":score", $score, PDO::PARAM_INT);
            $query->bindValue(":total", $total, PDO::PARAM_INT);
            $query->execute();
            $query2 = $conn->prepare($query2_text);
            $query2->execute($params);
            $conn->commit();
        } catch (PDOException $e) {
            die(json_encode(array(
                "status" => "error",
                "message" => $e->getMessage(),
            )));
        }

        die(json_encode(array(
            "status" => "success",
            "message" => "graded exam stored",
        )));
    }

    public function patch() {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);

        $instructor = $data['instructor'];  // not actually using it
        $student = $data['student'];
        $exam = $data['exam'];
        $taken_at = $data['taken_at'];

            $query_text = 
                "UPDATE grade SET released = TRUE
                 WHERE student = :student
                 AND   exam = :exam
                 AND   taken_at = :taken_at;
            ";
        try {

            $conn = MySQL::getInstance();
            $query = $conn->prepare($query_text);
            $query->bindValue(":student", $student, PDO::PARAM_INT);
            $query->bindValue(":exam", $exam, PDO::PARAM_INT);
            $query->bindValue("taken_at", $taken_at, PDO::PARAM_STR);
            $query->execute();

        }catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(array(
                "status" => "error",
                "message" => "failed to release exam grade",
            )));
        }
        die(json_encode(array(
            "status" => "success",
            "message" => "released exam grade on data_server",
        )));
    }
}
?>
