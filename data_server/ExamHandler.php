<?php
/*
    Expects:

    {
        exam_title: "Exam 1",
        instructor: 4,
        questions: [
            {
                id: 1,
                weight: 5,
            },
            {
                id: 2,
                weight: 7,
            },
            {
                ...
            }
        ]
    }
*/

class ExamHandler {


    public function get($id) {

    }


    public function post() {
        /*
            Insert into examquestion table
        */

        $data = file_get_content("php://input");
        $data = json_decode($data, true);


        $title          = $data['title'];
        $instructor     = $data['instructor'];

        $questions      = $data['questions'];

        $response = array();

        try {

            $conn = MySQL::getInstance();

            $conn->beginTransaction();

            $query1 = $conn->prepare(
                "INSERT INTO exam (title,instructor) VALUES (:title,:instructor);"
            );

            $query1->bindValue(":title", $title);
            $query1->bindValue(":instructor", $instructor);

            $query1->execute();

            $exam_id = $conn->lastInsertId();

            $params = array();

            $exam_id = $conn->lastInsertId();

            /* 
                BEGIN examquestion acrobatics
            */
            $query2_text = "INSERT INTO examquestion (exam,question,weight) VALUES ";
            foreach ($questions as $q) {
                $query2_text .= '(?,?,?),';
                $params[] = $exam_id;
                $params[] = $q['id'];
                $params[] = $q['weight'];
            }
            $query2_text = rtrim($query2_text, ",") . ";";
            /* 
                END examquestion acrobatics
            */

            $query2 = $conn->prepare($query2_text);
            $query2->execute($params);

            $conn->commit();

            $response['status'] = 'success';
            $response['message'] = '';
            $response['exam_id'] = $exam_id;

        } catch (PDOException $e) {

            http_response_code(500);

            $err = array(
                "status" => "error",
                "message" => $e->getMessage()
            );

            die(json_encode($err));
        }

        http_response_code(201);

        die(json_encode($response));
    }

}

?>
