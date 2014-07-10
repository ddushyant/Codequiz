<?php
class RegistrationHandler {
    public function post() {
        try {
            var_dump($_POST);
            $username = $_POST['username'];
            $password = $_POST['password'];
            $account_type = $_POST['account_type'];

            $query = MySQL::getInstance()
                ->prepare("INSERT INTO codequizuser (username, account_type, password) 
                           VALUES (:username, :account_type, :password)");

            $query->bindValue(':username', $username, PDO::PARAM_INT);
            $query->bindValue(':account_type', $account_type, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->execute();
        }catch (PDOException $e) {
            echo "UNABLE TO REGISTER";
            http_response_code(500);
            return;
        }
        echo "I MADE IT!";
        http_response_code(301);

    }
}
?>
