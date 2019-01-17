# Class Astro\Controller

源码 



## 属性

| #    | 属性           | 类型    | 默认值    | 描述                |
| ---- | -------------- | ------- | --------- | ------------------- |
| 1    | $action        | string  | _notfound | 缺省的方法          |
| 2    | $actionRun     | string  |           | 执行的方法          |
| 3    | $actionName    | string  |           | 请求的方法          |
| 4    | $actionMethod  | string  |           | 请求的 RESTful 方法 |
| 5    | $actionMethods | array   |           | 方法映射            |
| 6    | $methods       | string  |           | 所有可用方法        |
| 7    | $httpMethod    | string  |           | HTTP 方式           |
| 8    | $templateFile  | string  |           | 模板文件定义        |
| 9    | $templateAll   | boolean | false     | 使用全局模板        |
| 10   | $theme         | string  | aero      | 模板主题            |



## 方法

| #    | 方法          | 返回值 | 描述             |
| ---- | ------------- | ------ | ---------------- |
| 1    | __construct() |        | 传入参数         |
| 2    | __destruct()  | string | 执行方法         |
| 3    | __call()      |        | 重载方法         |
| 4    | _notfound()   | array  | 未找到           |
| 5    | _default()    |        |                  |
| 6    | _get()        |        | 自定义的映射方法 |



## 方法详情

### __construct($action = '')

1. 传入请求方法名称和 HTTP 方式
2. 检测方法是否存在



### __call($name, $arguments)

方法重载



### _notfound()



### _default()



### _get()



### __destruct()

1. 方法映射，执行方法
2. 模板路径分析，渲染视图







