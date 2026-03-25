<?php

namespace Frontend\Router;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {

            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = "#^" . preg_replace('#\{[a-z]+\}#', '([0-9]+)', $route['path']) . "$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "Page not found";
    }
}