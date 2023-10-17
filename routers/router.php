<?php

class Router {
    private $routes;

    public function __construct() {
        $this->routes = array();
    }

    public function addRoute($method, $uri, $callback) {
        $this->routes[] = array(
            'method' => $method,
            'uri' => $uri,
            'callback' => $callback
        );
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] == $method && $route['uri'] == $uri) {
                call_user_func($route['callback']);
                return;
            }
        }

        ResponseHandler::jsonResponse(null, 'URL not found', 404);
    }
}
