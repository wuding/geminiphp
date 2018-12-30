<?php
namespace app\controller;

class Index
{
	public $action = '_notfound';
	
	public function __construct($action = '')
	{
		# print_r([__METHOD__, __LINE__, __FILE__]);
		$this->httpMethod = strtolower($_SERVER['REQUEST_METHOD']);
		
		if ($action && in_array($action, get_class_methods($this))) {
			$this->action = $action;
		}
	}
	
	public function _notfound()
	{
		print_r([__METHOD__, __LINE__, __FILE__]);
	}
	
	public function index()
	{
		$data = [];
		switch ($this->httpMethod) {
			case 'put':
				$data = file_get_contents('php://input');
				parse_str($data, $_PUT);
				$data = $_PUT;
				break;
			default:
				$data = $_GET;
				break;
		}
		print_r([$data, $this->httpMethod, __METHOD__, __LINE__, __FILE__]);
	}
	
	public function __destruct()
	{
		$action = $this->action;
		$this->$action();
	}
}

