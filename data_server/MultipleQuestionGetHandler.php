<?php

function getByAttribute($attr,$val) {

    $result = NULL;

    try {

        $conn = MySQL::getInstance();

        $conn->beginTransaction();

        /*
            There's a potential SQL injection here
            $attr makes it past the prepared statement and can be used
            as an injection vector.
        */
        $query = $conn->prepare(
            "
                SELECT q.title, q.spec, s.name as subject, l.name as language
                FROM question q, language l, subject s
                WHERE q.$attr = :$val
                AND   q.subject = s.id
                AND   q.language = l.id;
            ");

        $query->bindValue($attr, $val, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $conn->commit();

        return $result;


    }catch (PDOException $e) {
        return NULL;
    }

    return $result;
}


class QuestionSubjectGetHandler {
    public function get($subject) {
        $response = array();

        $result = getByAttribute('subject', $subject);

        if ($result) {
            http_response_code(200);
            $response['status'] = 'success';
            $response['message'] = '';
        }else {
            http_response_code(404);
            $response['status'] = 'error';
            $response['message'] = 'Resource Not Found';
        }

        $result['questions'] = $result;

        die(json_encode($response));
    }
}
class QuestionLanguageGetHandler {
    public function get($language) {
        $response = array();

        $result = getByAttribute('language', $language);

        if ($result) {
            http_response_code(200);
            $response['status'] = 'success';
            $response['message'] = '';
        }else {
            http_response_code(404);
            $response['status'] = 'error';
            $response['message'] = 'Resource Not Found';
        }

        $result['questions'] = $result;

        die(json_encode($response));
    }
}
?>
