# Class Astro\Php

源码 



## 属性

| #    | 属性        | 类型   | 默认值                     | 描述       |
| ---- | ----------- | ------ | -------------------------- | -------- |
| 1    | $routeInfo  | array  |                            | 路由信息   |
| 2    | $uri        | string |                            | 请求路径   |
| 3    | $router     | object | FastRoute\simpleDispatcher | 网站路由器 |
| 4    | $template   | object | League\Plates\Engine       | 模板引擎   |
| 5    | $dispatcher | object | MagicCube\Dispatcher       | 模块调度器 |




## 方法



## 方法详情

### __construct()

1. 添加路由规则
2. 获取路由信息



### __destruct()

析构方法



### run()

1. 定义模板路径，定义全局变量 $PHP
2. 加载模块控制器



