<?php

namespace Astro;

class Php
{
    public $routeInfo = [];
    public $uri = null;
    public $httpMethod = '';
    
    public function __construct($config = [])
    {
        if (is_string($config)) {
            $config = include $config;
        }

        $this->routeRule = isset($config['route']) ? $config['route'] : [];

        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
            $this->addRoute($r, $this->routeRule);
        });

        // Fetch method and URI from somewhere
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        # $this->httpMethod = 'POST';
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $this->uri = $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($this->httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // ... call $handler with $vars
                break;
        }
        $this->routeInfo = $routeInfo;
        $this->router = $dispatcher;
    }
    
    public function run()
    {
        $this->template = new \League\Plates\Engine(APP_PATH . '/template');
        $GLOBALS['PHP'] = $this;
        $dispatcher = new \MagicCube\Dispatcher($this->routeInfo, $this->httpMethod);
    }

    public function addRoute($route = null, $rules = [])
    {
        foreach ($rules as $rule) {
            list($method, $routePattern, $handler) = $rule;
            $route->addRoute($method, $routePattern, $handler);
        }

        /*
        $route->addRoute(['GET', 'POST', 'PUT'], '/s', 'all:search/index/index');
        $route->addRoute(['GET', 'POST', 'PUT'], '/[index]', '/index/index');
        // {id} must be a number (\d+)
        $route->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
        // The /{title} suffix is optional
        $route->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
        */
    }
    
    public function __destruct()
    {
        $this->run();# 
    }
}
