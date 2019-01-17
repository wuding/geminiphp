# Class MagicCube\Dispatcher

源码



## 属性

| #    | 属性             | 类型    | 默认值 | 描述                 |
| ---- | ---------------- | ------- | ------ | -------------------- |
| 1    | $moduleFolder    | boolean | false  | 默认模块放统一文件夹 |
| 2    | $routeInfo       | array   |        | 路由信息             |
| 3    | $httpMethod      | string  |        | HTTP 方法            |
| 4    | $moduleName      | string  |        | 模块名               |
| 5    | $controllerName  | string  |        | 控制器名             |
| 6    | $actionName      | string  |        | 动作名               |
| 7    | $controllerClass | string  |        | 控制器类名           |



## 方法



## 方法详情

### __construct($routeInfo = [], $httpMethod = '')

1. 初始化属性
2. 执行调度



### dispatch($httpMethod = '', $uri = '')

1. 分析路由信息
2. 解析模块、控制器、动作名称
3. 解析控制器文件路径
4. 执行控制器

