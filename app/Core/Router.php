<?php

class Router
{
    protected $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controller, $methodName] = explode('@', $this->routes[$method][$uri]);

        require_once __DIR__ . "/../Controllers/$controller.php";
        $controller = new $controller();
        $controller->$methodName();
    }
}
