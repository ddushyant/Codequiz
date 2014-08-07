<?php

Class UserInfoHandler{

    public function get() {
            $logged_in = isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;

        if ($logged_in) {
            $account_type = $_SESSION["account_type"];

            $response = array(
                "logged_in" => $logged_in,
                "account_type" => $account_type
            );

            die(json_encode($response));
        }else{
         http_response_code(401);

         $response = array(
             "status" => "error",
             "message" => "no session found"
         );

         die(json_encode($response));
     }

    }
}

?>
