<?php
class ResponseHandler {
    public static function jsonResponse($data = null, $error = null, $statusCode = 200) {
        header("Content-Type: application/json");
        http_response_code($statusCode);

        echo json_encode(['data' => $data]);
        // echo json_encode(['data' => $data, 'error' => $error]);
        exit;
    }
}

?>