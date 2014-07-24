<?php
class LanguageHandler {
    public function get() {
        $response = array();

        try {
            $conn = MySQL::getInstance();
            $conn->beginTransaction();
            $query = $conn->prepare("SELECT id,name FROM language;");
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $conn->commit();

            $response['languages'] = $results;

        } catch (PDOException $e) {
            http_response_code(500);
            $response['status'] = 'error';
            $response['message'] = '';
            die(json_encode($response));
        }

        http_response_code(200);
        $response['status'] = 'success';
        $response['message'] = '';
        die(json_encode($response));
    }
}
?>
