<?php
class RegistrationHandler {
    public function post() {
        try {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $account_type = $_POST['account_type'];

            $rounds = 15;
            $bcrypt = new Bcrypt($rounds);

            $hash = $bcrypt->hash($password);

            $query = MySQL::getInstance()
                ->prepare("INSERT INTO codequizuser (username, account_type, password) 
                           VALUES (:username, :account_type, :password)");

            $query->bindValue(':username', $username, PDO::PARAM_INT);
            $query->bindValue(':account_type', $account_type, PDO::PARAM_STR);
            $query->bindValue(':password', $hash, PDO::PARAM_STR);
            $query->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
            http_response_code(500);
        }

        // entity created
        http_response_code(301);

    }
}
?>
