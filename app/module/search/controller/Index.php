<?php

namespace app\module\search\controller;

debug_file(__FILE__);

class Index extends \Astro\Controller
{
	public $action = '_notfound';
	public $actionMethods = [
		'index' => [
			'get' => 'index',
			'post' => 'create',
			'put' => 'update',
			'delete' => 'destroy',
		],
	];
	
	public function _notfound()
	{
		print_r([__METHOD__, __LINE__, __FILE__]);
	}
	
	public function index()
	{
		# $this->templateFile = 'aero/index/index';
		$query = isset($_GET['q']) ? trim($_GET['q']) : '';
		$scheme = null;
		if ($query) {
			if (preg_match("/^([a-z0-9]+):(.*)/i", $query, $matches)) {
				# print_r($matches);
				$scheme = strtolower($matches[1]);
			}
			switch ($scheme) {
				case 'https':
				case 'http':
					return $this->http($query);
					break;
				default;
					break;
			}
		}
		return ['url' => $query];
	}
	
	public function http($url)
	{
		$uri = parse_url($url);
		#print_r($url);
		#exit;
		$urn = $uri['scheme'] . '://' . $uri['host'] . $uri['path'];
		$extension = null;
		if (preg_match("/\.([a-z0-9]+)$/i", $urn, $matches)) {
			# print_r($matches);
			$extension = strtolower($matches[1]);
		}
		switch ($extension) {
			case 'm3u8':
				return $this->m3u8($url);
				break;
			default;
				break;
		}
		return ['name' => $url];
	}
	
	public function m3u8($url)
	{
		# $this->templateFile = 'search:aero@player/m3u8';
		return ['url' => $url];
	}
	
	public function _put_index()
	{
		print_r([isset($_GET['q']) ? $_GET['q'] : print_r($_GET, true), __METHOD__, __LINE__, __FILE__]);
	}
	
	public function _post_index()
	{
		print_r([isset($_POST['q2']) ? $_POST['q2'] : print_r($_POST, true), __METHOD__, __LINE__, __FILE__]);
	}
}

