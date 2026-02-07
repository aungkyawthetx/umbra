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

            if (isset($this->routes[$method][$uri])) {
                [$controller, $methodName] = explode('@', $this->routes[$method][$uri]);
                require_once __DIR__ . "/../Controllers/$controller.php";
                $controller = new $controller();
                $controller->$methodName();
                return;
            }

            foreach ($this->routes[$method] ?? [] as $route => $action) {
                if (strpos($route, '{') === false) {
                    continue;
                }

                $pattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $route);
                if (!preg_match('#^' . $pattern . '/?$#u', $uri, $matches)) {
                    continue;
                }

                preg_match_all('/\{([^\/]+)\}/', $route, $paramNames);
                $params = $paramNames[1] ?? [];
                array_shift($matches);

                foreach ($params as $i => $name) {
                    $_GET[$name] = rawurldecode($matches[$i] ?? '');
                }

                [$controller, $methodName] = explode('@', $action);
                require_once __DIR__ . "/../Controllers/$controller.php";
                $controller = new $controller();
                $controller->$methodName();
                return;
            }

            http_response_code(404);
            require_once __DIR__ . '/../../views/errors/404.php';
            return;
        }
    }
    
?>
