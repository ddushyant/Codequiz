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
                ->prepare("SELECT * FROM codequizuser WHERE username = :username ;");

            $query->bindValue(':username', $username, PDO::PARAM_STR);

            $query->execute();
            
            $user = $query->fetch(PDO::FETCH_ASSOC);

            $n = $query->rowCount();
            $db_hashed_password = $user['password'];

            if ($n && $bcrypt->verify($password,$db_hashed_password)) {
                http_response_code(204);
            }else {
                http_response_code(401);
            }
        }catch (PDOException $e) {
            $err = $e->getMessage();
            $file = 'out.txt';

            // Open the file to get existing content
            $current = file_get_contents($file);
            // Append a new person to the file
            $current .= $err . '\n';
            // Write the contents back to the file
            file_put_contents($file, $current);

            echo json_encode(array(
                "error" => $e->getMessage()
            ));
            http_response_code(500);
        }
    }
}
