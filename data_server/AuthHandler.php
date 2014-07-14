<?php
class AuthHandler {
    public function post() {
        try {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $rounds = 5;
            $bcrypt = new Bcrypt($rounds);

            $hash = $bcrypt->hash($password);


            $query = MySQL::getInstance()
                ->prepare("SELECT * FROM codequizuser WHERE username = :username ;");

            $query->bindValue(':username', $username, PDO::PARAM_STR);

            $query->execute();
            
            $user = $query->fetch(PDO::FETCH_ASSOC);

            $n = $query->rowCount();
            $db_hashed_password = $user['password'];

            if ($n && $bcrypt->verify($password,$db_hashed_password)) {
                http_response_code(204);
                die();
            }else {
                http_response_code(401);
                die();
            }
        }catch (PDOException $e) {

            $err = array(
                "error" => $e->getMessage()
            );

            http_response_code(500);
            die(json_encode($err));
        }
    }
}
