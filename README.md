# ♊ Geminiphp

这个时期只使用 Composer 类加载，路由 nikic/fast-route 模板 league/plates

模块调用使用自己写的 wuding/magic-cube 分默认模块和多模块，控制器和动作支持 RESTful 方式

模板支持主题和设备

自带控制台调试

快速开发 RESTful APIs 和 Web 应用的 PHP 框架

## 起步

* ### 编写 composer.json
```
{
    "name": "wuding/miniphp",
    "type": "library",
    "version": "0.0.1",
    "description": "A PHP Framework",
    "keywords": ["framework", "mvc"],
    "homepage": "https://github.com/wuding/astrophp",
    "license": "Apache-2.0",
    "authors": [
        {
          "name": "Benny Wu",
          "email": "contact@wubenli.com",
          "homepage": "http://wubenli.com",
          "role": "Developer"
        }
      ],
    "require": {
        "php": "^5.4|^7.0",
        "nikic/fast-route": "^1.3.0",
        "league/plates": "^3.3",
        "catfan/Medoo": "^1.5"
    },
    "autoload": {
        "psr-4": {
            "Astro\\": "src/Astro/",
            "MagicCube\\": "src/MagicCube/",
            "app\\": "app/"
        }
    }
}
```

* ### 使用 Composer 安装

`composer install`

* ### 引导文件
/app/bootstrap.php
```
define('APP_PATH', __DIR__);
require APP_PATH . '/../vendor/autoload.php';
```

* ### 入口文件
/web/index.php
```
require_once __DIR__ . '/../app/bootstrap.php';
new Astro\Php();
```

* ### MVC 框架核心文件
/src/Astro/Php.php
```
<?php
namespace Astro;

class Php
{
	public $routeInfo = [];
	public $uri = null;
	
	public function __construct()
	{
	}
	
	public function run()
	{
		$this->routeInfo = $this->routeInfo();
		$this->template = new \League\Plates\Engine(APP_PATH . '/template');
		$GLOBALS['PHP'] = $this;
		$dispatcher = new \MagicCube\Dispatcher($this->routeInfo, $_SERVER['REQUEST_METHOD']);
	}
	
	public function __destruct()
	{
		$this->run();
	}
}
```

* ### 使用路由
```
	public routeRule(\FastRoute\RouteCollector $r)
	{
		$r->addRoute(['GET', 'POST', 'PUT'], '/[index]', '/index/index');
	}
	
	public router()
	{
		$dispatcher = \FastRoute\simpleDispatcher($this->routeRule());
	}
	
	public routeInfo()
	{
		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
	}
```

* ### 控制器
/app/controller/Index.php
```
<?php
namespace app\controller;

class Index extends \Astro\Controller
{
	public function index()
	{
		$this->templateFile = 'index/index';
		return ['name' => 'value'];
	}
}
```

## 进阶

* ### 使用模块
/app/module/index/controller/Index.php


* ### HTTP 请求方法
文件夹方式
/app/controller/get/Index.php

动作命名方式

配置映射方式

* ### 模板
/src/Controller.php
```
echo $html = $php->template->render($this->templateFile, $var);
```

/app/template/index/index.php
```

```

/app/template/layout.php
```

```

"wuding/equiv-route": "^0.1",
"wuding/magic-cube": "^0.1",
"wuding/topdb": "^0.1",
"wuding/newui": "^0.1",