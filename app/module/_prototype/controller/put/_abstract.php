<?php

namespace app\module\_prototype\controller\put;

class _abstract extends \Astro\Controller
{
	public function __construct($action = '')
	{
		parent::__construct($action);
		print_r([$action, __METHOD__, __LINE__, __FILE__]);# 
	}
	
	public function __destruct()
	{
		parent::__destruct();
		
	}
}
