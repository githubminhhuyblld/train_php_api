<?php
class RequestHandler {
    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getRequestUri() {
        return $_SERVER['REQUEST_URI'];
    }
}
