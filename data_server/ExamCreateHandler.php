<?

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
class ExamCreateHandler {
    public function post() {
        /*
            Insert into examquestion table
        */

        $exam_name      = $_POST['exam_name'];
        $author         = $_POST['author'];
        $question_no    = $_POST['question_no'];
        $duration       = $_POST['duration'];
        $start_date     = $_POST['start_date'];
        $end_date       = $_POST['end_date'];
        $questions      = json_decode($_POST['questions'], true);



        $args = array_fill(0, count($questions) * count($questions[0]), '?');

        $params = array();
        foreach($questions as $q)
        {
               $params[] = 1;   // dummy exam id
               foreach($q as $value)
               {
                $params[] = $value;
               }
        }

        $query = "INSERT INTO examquestion (exam_id,question_id) VALUES (".implode(',', $args).")";
        $query2 = "INSERT INTO examquestion(exam_id,question_no)
        $stmt = DB::getInstance()->prepare($query);
        $stmt->execute($params);
    }
}

?>
