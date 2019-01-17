<?php
namespace app\controller;

class Index extends \Astro\Controller
{
	public $action = '_notfound';
	
	public function _notfound()
	{
		print_r([__METHOD__, __LINE__, __FILE__]);
	}

	public function index()
	{
		return [];
	}
}
