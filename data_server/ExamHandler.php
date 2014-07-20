<?php
/*
    Expects:

    {
        exam_name: "Exam 1",
        author: 4,
        question_no: 10,
        duration: 30,                 -- minutes
        start_date: "May 15, 2014",
        end_date:   "May 16, 2014",
        questions: [
            {
                qid: 1,
                qweight: 5,
            },
            {
                qid: 2,
                qweight: 7,
            },
            {
                ...
            }
        ]
    }
*/

class ExamHandler {
    public function get($id) {

        //JOINS MOTHER FUCKER
    }

    public function post() {
        /*
            Insert into examquestion table
        */

        $name           = $_POST['name'];
        $duration       = $_POST['duration'];
        $exam_date      = $_POST['exam_date'];
        $questions      = $_POST['questions'];

        $conn = MySQL::getInstance();

        $args = array_fill(0, count($questions), '?');
        $params = array();

        $query = $conn->prepare(
            "INSERT INTO exam (name, exam_date, question_no, duration_minutes)
             VALUES (:name, :exam_date, :question_no, :duration_minutes);
            "
        );

        $query->bindValue(":name", $name , PDO::PARAM_STR);
        $query->bindValue(":exam_date", $exam_date, PDO::PARAM_STR);
        $query->bindValue(":duration_minutes", $duration_minutes, PDO::PARAM_INT);

        $query->execute();

        $exam_id = $conn->lastInsertId();

        foreach($questions as $q)
        {
            $params[] = $exam_id;   // dummy exam id
            $params[] = $q;
        }

        $query = "INSERT INTO examquestion (exam_id,question_id) VALUES (" . implode('),(', $args) . ")";

    }

}

?>
