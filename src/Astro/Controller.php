<?php

namespace Astro;

class Controller
{
	public $action = '_notfound'; //缺省的方法名称	
	public $actionRun = null; //最终执行的方法名称
	public $actionName = null; //请求的方法名称
	public $actionMethod = null; //请求的HTTP方法名称
	public $actionMethods = [
		'_default' => [
			# 'get' => '_get',
			'post' => '_post',
			'put' => '_put',
			'delete' => '_delete',
		],
	]; //方法映射配置
	public $methods = null;	 //所有的方法名称
	public $httpMethod = null; //请求的HTTP方式
	public $templateFile = null;
	public $theme = 'aero';
	public $templateAll = false;
	public $enable_view = true;
	
	public function __construct($action = '')
	{
		$action = $action ? : $GLOBALS['PHP']->dispatcher->actionName;# 
		$this->actionName = $action;
		$action = $action ? : $this->action;
		
		$this->httpMethod = strtolower($GLOBALS['PHP']->httpMethod);
		
		/* 检测方法是否存在 */
		$this->methods = $methods = get_class_methods($this);
		if ($action) {			
			$this->actionMethod = $actionMethod = '_' . $this->httpMethod . '_' . $action;
			if (in_array($actionMethod, $methods)) {
				$this->action = $actionMethod;
			} elseif (in_array($action, $methods)) {
				$this->action = $action;
			}
		}
	}
	
	public function __call($name, $arguments)
	{
		return [$name, $arguments, __FILE__, __LINE__];
	}
	
	public function _notfound()
	{
		return [];
	}
	
	public function _default()
	{
		return [];
	}
	
	public function _get()
	{
		return [];
	}
	
	/*
	public function _get__default()
	{
		print_r([__METHOD__, __LINE__, __FILE__]);
	}
	*/
	
	public function __destruct()
	{
		$php = $GLOBALS['PHP'];# print_r($php);
		$dispatcher = $php->dispatcher;
		
		$action = $this->action;
		$maps = $this->actionMethods;
		$method = $this->httpMethod;
		
		/* 方法映射 */
		if (isset($maps[$action]) && $map = $maps[$action]) {
			if (isset($map[$method]) && $name = $map[$method]) {
				if (in_array($name, $this->methods)) {
					$action = $name;
				}
			}
		}
		$this->actionRun = $action;
		$php->controller = $this;
		
		/* 执行方法 */
		$var = $this->$action();
		$var = $var ? : ['nothing' => null];
		/*
		if ($var) {
			print_r([$var, $this->templateFile, __METHOD__, __LINE__, __FILE__]);
		}
		*/
		
		/* 默认配置 */
		$theme = $this->theme;
		$module = $dispatcher->moduleName;		
		$controller = $dispatcher->controllerName;
		$path = '/' . $action;
		$extension = null;
		$default = [$theme, $module, $controller, $path, $extension];# print_r($default);exit;
		$custom = [];
		
		/* 解析自定义 */
		$file = trim($this->templateFile);		
		if (preg_match("/^([a-z0-9]+:|)([a-z0-9]+@|)(.+)/i", $file, $matches)) {
			# print_r($matches);
			$module = trim($matches[1], ':') ? : $module;
			$theme = trim($matches[2], '@') ? : $theme;
			$path = $matches[3] ? : '';
			$explode = explode('/', $path, 2);
			if (preg_match("/^\//", $path)) {
				$path = $controller . $path;
			} elseif (2 > count($explode)) {
				$controller = '';
			}
			$custom = [$theme, $module, $controller, $path, $extension, $file, $matches, $explode];
		} else {
			$path = $controller . $path;
		}
		
		/* 重新编解码 */
		# print_r([$module, $theme, $path]);
		$file = $module . ':' . $theme . '@' . $path;# echo exit;
		$url = parse_url('tpl://' . $file);
		$url_path = isset($url['path']) ? $url['path'] : null;
		$path = $url_path ? : null;
		$pathinfo = pathinfo($path);
		if (isset($pathinfo['extension'])) {
			$extension = $pathinfo['extension'];
			if ($extension) {
				$php->template->setFileExtension(null);
			} else {
				$path = preg_replace("/([\.]+)$/", '', $path);
			}
		}
		
		$user = isset($url['user']) ? $url['user'] : null;
		$pass = isset($url['pass']) ? $url['pass'] : null;
		$host = isset($url['host']) ? $url['host'] : null;
		$theme = $pass ? : $theme;
		$module = $user ? : $module;
		$controller = $host ? : $controller;		
		$decode = [$theme, $module, $controller, $path, $extension, $file, $url, $pathinfo];
		
		/* 模板路径 */
		$module_folder = $this->templateAll ? ($module ? : 'index') . '/' : '';
		$script = $theme . '/' . $module_folder . $controller . $path;
		$template_folder = '';
		if (!$this->templateAll && $module && 'index' != $module) {
			$template_folder = APP_PATH . '/module/' . $module . '/template';
			$php->template->addFolder($module, $template_folder);
			$script = $module . '::' . $script;
		}
		# print_r([$default, $custom, $decode, $script, $module_folder, $template_folder]);exit;
		
		/* 渲染页面 */
		if ($this->enable_view) {
			echo $html = $php->template->render($script, $var);
		}
		
	}
}
