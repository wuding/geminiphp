<?php
namespace MagicCube;

class Dispatcher
{
	public $moduleFolder = 0; //把默认模块控制器也放在统一模块文件夹
	
	public function __construct($routeInfo = [], $httpMethod = '')
	{
		# print_r([$routeInfo, __METHOD__, __LINE__, __FILE__]);# 
		$this->routeInfo =  $routeInfo;
		$this->httpMethod =  $httpMethod;
		$this->dispatch();
	}
	
	public function dispatch($httpMethod = '', $uri = '')
	{
		$httpMethod = $httpMethod ? : $this->httpMethod;
		$routeInfo = $this->routeInfo;
		
		$httpMethod = strtolower($httpMethod);
		$handler = '/index/index';
		$vars = [];
		$status = $routeInfo[0];
		
		switch ($status) {
			case 0:
				// ... 404 Not Found
				$handler = '_prototype/_abstract/_default';
				break;
			case 2:
				$allowedMethods = $routeInfo[1];
				// ... 405 Method Not Allowed
				break;
			case 1:
				$handler = $routeInfo[1];
				$vars = $routeInfo[2];
				// ... call $handler with $vars
				break;
		}
		
		if ($handler) {
			if (is_string($handler)) {
				$ctrlInfo = explode(':', $handler);
				$count = count($ctrlInfo);
				if (1 < $count) {
					$httpMethod = $ctrlInfo[0];
					$handler = $ctrlInfo[1];
				} else {
					$handler = $ctrlInfo[0];
				}
				# print_r($ctrlInfo);exit;
				
				$pathInfo = explode('/', $handler);
				$this->moduleName = $module = $pathInfo[0] ? : 'index';
				$this->controllerName = $controller = $pathInfo[1] ? : 'index';
				$this->actionName = $action = $pathInfo[2] ? : 'index';
				
				$moduleFolder = 1;
				if (!$this->moduleFolder) {
					if ('index' == strtolower($module)) {
						$moduleFolder = 0;
					}
				}
				$module_str = $moduleFolder ? '\\module\\' . $module : '';
				if (preg_match("/,|all/", $httpMethod) || !$httpMethod) {
					$httpMethod = '';
				} else {
					$httpMethod = "\\$httpMethod";
				}
				
				$class = "\\app$module_str\\controller$httpMethod\\$controller";
				if ($httpMethod && !class_exists($class)) {
					$class = "\\app$module_str\\controller\\$controller";
				}
				$this->controllerClass = $class;
				$GLOBALS['PHP']->dispatcher = $this;
				
				$object = new $class();# $action
			}
		}
		# print_r([$httpMethod, $uri]);
	}
	
	public function __destruct()
	{
		
	}
}
