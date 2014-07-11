<?php
class RegistrationHandler {
    public function post() {
        $data = array();
        try {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $account_type = isset($_POST['account_type']) ? $_POST['account_type'] : 'student';

            $rounds = 15;
            $bcrypt = new Bcrypt($rounds);

            $hash = $bcrypt->hash($password);

            $data['username'] = $username;
            $data['password'] = $hash;

            $query = MySQL::getInstance()
                ->prepare("INSERT INTO codequizuser (username, account_type, password) 
                           VALUES (:username, :account_type, :password)");

            $query->bindValue(':username', $username, PDO::PARAM_INT);
            $query->bindValue(':account_type', $account_type, PDO::PARAM_STR);
            $query->bindValue(':password', $hash, PDO::PARAM_STR);
            $query->execute();

        }catch (PDOException $e) {
            echo json_encode($data);
            http_response_code(500);
        }

        // entity created
        echo json_encode($data);
        http_response_code(301);

    }
}
?>
