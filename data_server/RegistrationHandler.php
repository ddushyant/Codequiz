<?php
class RegistrationHandler {
  public function post() {
      $data = array();

        try {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $account_type = isset($_POST['account_type']) ? $_POST['account_type'] : 'student';

            $rounds = 5;
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
            http_response_code(500);
            $err = array(
                "error" => $e->getMessage(),
            );

            die(json_encode($err));
        }

        // entity created
        http_response_code(201);
        die(json_encode($data));
    }
}
?>
