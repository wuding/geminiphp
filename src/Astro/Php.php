<?php

namespace Astro;

class Php
{
	public $routeInfo = [];
	public $uri = null;
	
	public function __construct()
	{
		$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
			$r->addRoute(['GET', 'POST', 'PUT'], '/s', 'all:search/index/index');
			$r->addRoute(['GET', 'POST', 'PUT'], '/[index]', '/index/index');
			// {id} must be a number (\d+)
			$r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
			// The /{title} suffix is optional
			$r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
		});

		// Fetch method and URI from somewhere
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		$uri = $_SERVER['REQUEST_URI'];

		// Strip query string (?foo=bar) and decode URI
		if (false !== $pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}
		$this->uri = $uri = rawurldecode($uri);

		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
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
		$dispatcher = new \MagicCube\Dispatcher($this->routeInfo, $_SERVER['REQUEST_METHOD']);
	}
	
	public function __destruct()
	{
		$this->run();# 
	}
}
