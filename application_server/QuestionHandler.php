<?php
class QuestionHandler {
    public function get($id) {
            $url = "http://web.njit.edu/~arm32/data_server/app.php/exam/$id";
            
            $code = 0;

            $result = MyGet($url, $code);

            if($code === "200") {
                die($result);
            }else {
            }
    }
}
?>
