<?php
class RequestHandler {
    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getRequestUri() {
        return $_SERVER['REQUEST_URI'];
    }
    public static function getPostData() {
        $rawData = file_get_contents("php://input");
        return json_decode($rawData, true);
    }
    public static function getQueryParam($key, $default = null) {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

}
