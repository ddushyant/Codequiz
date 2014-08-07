<?php
class ExamReviewHandler {
    public function get($exam_id) {
        $taken_at = $_GET['taken_at'];
        $user_id = $_SESSION['user_id'];

        $data = array(
            "student" => $user_id,
            "taken_at" => $taken_at,
            "exam" => $exam_id,
        );

        $code2 = 0;
        $url2 = "http://web.njit.edu/~arm32/data_server/app.php/examanswer?";
        $url2 .= http_build_query($data);

        $result2 = MyGet($url2, $code2);

        die($result2);
    }
}
?>
