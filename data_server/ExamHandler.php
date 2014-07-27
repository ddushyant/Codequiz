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

    if (is_null($id)) {

      $n = isset($_GET['n']) ? $_GET['n'] : '10';

      $query_text = "SELECT e.id,e.title FROM exam e LIMIT :n";
      try {
        $conn = MySQL::getInstance();

        $conn->beginTransaction();
        $query = $conn->prepare($query_text);
        $query->bindValue(":n", $n, PDO::PARAM_STR);
        $query->execute();

        $exams = $query->fetchAll(PDO::FETCH_ASSOC);
        $conn->commit();

        $response = array(
          "status" => "success",
          "message" => "",
          "exams" => $exams
        );

        die(json_encode($response));
      }catch (PDOException $e) {
            http_response_code(500);

            $err = array(
                "status" => "error",
                "message" => $e->getMessage()
            );

            die(json_encode($err));
      }

    }else {
      $query1_text = 
        "SELECT q.id,q.title,q.spec,q.qtype,eq.weight,l.name as language
        FROM question q
        JOIN language l ON q.language = l.id
        JOIN examquestion eq ON eq.question = q.id
        WHERE eq.exam = :exam_id;
        ";

      $query2_text = 
        "SELECT q.id as qid, a.id, a.answer_key, a.answer_value, a.correct
         FROM (SELECT * FROM examquestion WHERE exam = :exam_id) AS eq 
         JOIN question q ON eq.question = q.id 
         JOIN answer a on a.question = q.id;
        "; 

      $query3_text = 
        "SELECT id,title FROM exam
         WHERE exam.id = :exam_id
         ";


      $response = array(
        "status"=>"",
        "message"=>"",
      );

      try {
        $conn = MySQL::getInstance();

        $conn->beginTransaction();

        $query = $conn->prepare($query1_text);
        $query->bindValue(":exam_id", $id, PDO::PARAM_STR);
        $query->execute();
        $questions = $query->fetchAll(PDO::FETCH_ASSOC);

        $query2 = $conn->prepare($query2_text);
        $query2->bindValue(":exam_id", $id, PDO::PARAM_STR);
        $query2->execute();
        $answers = $query2->fetchAll(PDO::FETCH_ASSOC);

        $query3 = $conn->prepare($query3_text);
        $query3->bindValue(":exam_id", $id, PDO::PARAM_STR);
        $query3->execute();
        $exam = $query3->fetch(PDO::FETCH_ASSOC);

        $conn->commit();

        $response['exam_id'] = $exam['id'];
        $response['title'] = $exam['title'];
        $response['questions'] = $questions;

        foreach ($response['questions'] as $k => $q) {
          $response['questions'][$k]['answers'] = array();
          foreach ($answers as $a) {
            if ($a['qid'] === $q['id']) {
              $response['questions'][$k]['answers'][] = $a;
            }
          }
        }


      } catch (PDOException $e) {
        http_response_code(500);
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
        die(json_encode($response));
      }
      $response['status'] = 'success';

      die(json_encode($response));

    }
  }


    public function post() {
        /*
            Insert into examquestion table
        */

        
        $data = file_get_contents("php://input");
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
                $params[] = $q['qid'];
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
