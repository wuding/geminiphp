<?php

namespace app\controller\get;

class Index extends \Astro\Controller
{
	public $action = '_default';
	
	/*
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function _notfound()
	{
		print_r([__METHOD__, __LINE__, __FILE__]);
	}
	
	
	
	
	public function __destruct()
	{
		parent::__destruct();
	}
	*/
	
	public function index()
	{
		$query = isset($_GET['q']) ? trim($_GET['q']) : '';
		# print_r([$GLOBALS['PHP'], __METHOD__, __LINE__, __FILE__]); 
		# $this->templateFile = 'index/index';
		# $url = 'http://www.lan.urlnk.com/s?q=http%3A%2F%2Fcdn3.polaroidchina.com%3A8091%2F20180724%2F4NnA61wz%2Findex.m3u8&debug=';
		# $url = 'http://www.lan.urlnk.com/s?q=http%3A%2F%2Fcdn3.polaroidchina.com%3A8091%2F20180721%2FB67ac4E5%2Findex.m3u8&debug=';
		# header('Location: ' . $url); exit;
		return ['name' => 'Benny', 'url' => $query];
	}
}

