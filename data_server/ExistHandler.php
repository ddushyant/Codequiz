<?php 

class ExistHandler {

    public function get($username) {

        $query = MySQL::getInstance()->prepare("SELECT 1 FROM codequizuser WHERE username=:username");
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->execute();

        $n = $query->rowCount();

        if ($n) {
            http_response_code(204);
        }else {
            http_response_code(404);
        }
        
    }

}
?>
