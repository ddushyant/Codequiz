<?php
class AuthHandler {
    public function post() {
        try {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $rounds = 15;
            $bcrypt = new Bcrypt($rounds);

            $hash = $bcrypt->hash($password);

            $query = MySQL::getInstance()
                ->prepare("SELECT 1 FROM codequizuser
                           WHERE username = :username
                           AND   password = :password;");

            $query->bindValue(':username', $username, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);

            $query->execute();

            $n = $query->rowCount();
            echo "MADE THE QUERY!";
            if ($n) {
                http_response_code(204);
            }else {
                http_response_code(401);
            }
        }catch (PDOException $e) {
            echo "COULD NOT DO SHIT";
        }
    }
}
