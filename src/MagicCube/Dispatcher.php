<?php
namespace MagicCube;

class Dispatcher
{
    public $defaultModuleFolder = 0; //0放应用文件夹 1、2 同下
    public $moduleFolder = 2; //0不使用多模块 1使用多模块 2统一模块文件夹
    public $methodFolder = 0; //1使用方法文件夹（仅有单个方法时）
    public $moduleName = 'index';
    public $controllerName = 'index';
    public $actionName = 'index';

    public function __construct($routeInfo = [], $httpMethod = '')
    {
        # print_r([$routeInfo, __METHOD__, __LINE__, __FILE__]);
        $this->routeInfo =  $routeInfo;
        $this->httpMethod =  $httpMethod;
        $this->dispatch();
    }

    public function dispatch($httpMethod = '', $uri = '')
    {
        if ($this->moduleFolder < $this->defaultModuleFolder) {
            $this->defaultModuleFolder = $this->moduleFolder;
        }

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

                $module = $controller = $action = '';

                $pathInfo = explode('/', $handler);
                $count = count($pathInfo);
                switch ($count) {
                    case 0:
                        break;
                    case 1:
                        list($action) = $pathInfo;
                        break;
                    case 2:
                        list($controller, $action) = $pathInfo;
                        break;
                    case 3:
                        list($module, $controller, $action) = $pathInfo;
                        break;
                    default:
                        break;
                }
                $this->moduleName = $module = $module ? : $this->moduleName;
                $this->controllerName = $controller = $controller ? : $this->controllerName;
                $this->actionName = $action = $action ? : $this->actionName;

                if ('index' == strtolower($module)) {
                    $this->moduleFolder = $this->defaultModuleFolder;
                }
                if (!$this->moduleFolder) {
                    $module = 'index' == $module ? $module : '';
                    $this->controllerName = $controller = $this->moduleName;;
                    $this->actionName = $action = $this->controllerName;
                }
                $module_str = 2 == $this->moduleFolder ? '\\module\\' . $module : (1 == $this->moduleFolder ? '\\' . $module : '');
                if (preg_match("/,|all/", $httpMethod) || !$httpMethod) {
                    $httpMethod = '';
                } elseif ($this->methodFolder) {
                    $httpMethod = "\\$httpMethod";
                }

                $class = "\\app$module_str\\controller$httpMethod\\$controller";
                // 方法未定义
                if ($httpMethod && !class_exists($class)) {
                    $class = "\\app$module_str\\controller\\$controller";
                    // 控制器未定义
                    if (!class_exists($class)) {
                        if ('_abstract' != $controller) {
                            $controller_tmp = '_abstract';
                            $class = "\\app$module_str\\controller\\$controller_tmp";
                        }
                        // 模块未定义
                        if (!class_exists($class)) {
                            $module = '_prototype';
                            $module_str_tmp = 2 == $this->moduleFolder ? '\\module\\' . $module : (1 == $this->moduleFolder ? '\\' . $module : '');
                            $class = "\\app$module_str_tmp\\controller\\$controller";
                            // 控制器还是未定义
                            if (!class_exists($class)) {
                                if ('_abstract' != $controller) {
                                    $controller_tmp = '_abstract';
                                    $class = "\\app$module_str_tmp\\controller\\$controller_tmp";
                                }
                            }
                        }
                    }
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
