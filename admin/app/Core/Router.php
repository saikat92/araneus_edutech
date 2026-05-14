<?php
namespace App\Core;

class Router {
    private array $routes = [];
    public function get(string $pattern, string $handler): void {
        $this->routes['GET'][$pattern] = $handler;
    }

    public function post(string $pattern, string $handler): void {
        $this->routes['POST'][$pattern] = $handler;
    }

    public function dispatch(string $uri, string $method): void {
        $uri = strtok($uri, '?');
        $uri = '/' . trim($uri, '/');

        foreach ($this->routes[$method] ?? [] as $pattern => $handler) {
            $regex = preg_replace('/\{([a-z]+)\}/', '([^/]+)', $pattern);
            $regex = '#^' . $regex . '$#';
            if (preg_match($regex, $uri, $matches)) {
                array_shift($matches);
                [$controllerName, $action] = explode('@', $handler);
                $controllerClass = "App\\Controllers\\$controllerName";
                if (!class_exists($controllerClass)) {
                    http_response_code(404);
                    echo "Controller not found: $controllerClass";
                    return;
                }
                $controller = new $controllerClass();
                if (!method_exists($controller, $action)) {
                    http_response_code(404);
                    echo "Method not found: $action";
                    return;
                }
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        http_response_code(404);
        require APP_ROOT . '/views/404.php';
    }
}
