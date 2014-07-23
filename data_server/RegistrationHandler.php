<?php
class RegistrationHandler {
  public function post() {

        $data = file_get_content("php://input");
        $data = json_decode($data, true);

        $username = $data['username'];
        $password = $data['password'];
        $account_type = isset($data['account_type']) ? $data['account_type'] : 'student';

        $rounds = 5;
        $bcrypt = new Bcrypt($rounds);

        $hash = $bcrypt->hash($password);
        $response = array();

        try {

            $conn = MySQL::getInstance();
            $conn->beginTransaction();

            $query = MySQL::getInstance()
                ->prepare("INSERT INTO codequizuser (username, account_type, password) 
                           VALUES (:username, :account_type, :password)");

            $query->bindValue(':username', $username, PDO::PARAM_INT);
            $query->bindValue(':account_type', $account_type, PDO::PARAM_STR);
            $query->bindValue(':password', $hash, PDO::PARAM_STR);
            $query->execute();

            $user_id = MySQL::getInstance()->lastInsertId();

            $conn->commit();

            $response['user_id'] =  $user_id;

        }catch (PDOException $e) {
            http_response_code(500);
            $err = array(
                "status" => "error",
                "message" => $e->getMessage(),
            );

            die(json_encode($err));
        }

        // entity created
        http_response_code(201);
        $response['status'] = 'success';
        $response['message'] = '';
        die(json_encode($response));
    }
}
?>
