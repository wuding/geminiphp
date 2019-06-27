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
		$urn = $uri['scheme'] . '://' . $uri['host'] . (isset($uri['path']) ? $uri['path'] : '');
		$extension = $host = null;

		// 代理主机配置
		$hosts = array(
			'schema.org' => 'schema.org',
			'www.php.net' => 1,
			'fanyi.baidu.com' => 1,
		);

		// 扩展名匹配
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

		// 主机匹配
		# if (array_key_exists($uri['host'], $hosts)) {
			# $host = $hosts[$uri['host']];
			return $this->proxy($url);
		# }

		// 无任何匹配
		return ['url' => $url];
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

	public function proxy($url)
	{
		global $_CONFIG;
		include $_CONFIG['autoload']['php-ext'] . '/PhpCurl.php';
		include $_CONFIG['autoload']['php-ext'] . '/Filesystem.php';

		$arg_url = $url;
		$uri = parse_url($url);

		// 修复地址
		$path = isset($uri['path']) ? $uri['path'] : '';
		$pathinfo = pathinfo($path);
		$basename = isset($pathinfo['basename']) ? $pathinfo['basename'] : '';
		if (!$basename) {
			$basename = md5('') . '.txt';
		}

		// 重置地址
		$dirname = preg_replace('/^[\/\\\]+$/', '', isset($pathinfo['dirname']) ? $pathinfo['dirname'] : '');
		$dirname = $dirname ? '/' . $dirname . '/' : '/';
		$filename = array('dirname' => $dirname );
		$filename['basename'] = $basename;
		$uri['path'] = $name = implode('', $filename);
		if (isset($uri['query'])) {
			$uri['query'] = '__' . $uri['query'];
		}
		$uri['scheme'] .= '://';
		$file = implode('', $uri);

		$url = preg_replace(['/:/', '/[\/\\\]+/'], ['', '/'], $file);
        $url = $_CONFIG['cache']['web'] . '/' . $url;
		# print_r(get_defined_vars());exit;

        // 直接读取
        if (file_exists($url)) {
            echo $data = \Ext\Filesystem::getContents($url);
            exit;
        }

        // 写入
        $curl = new \Ext\PhpCurl($url);
		$data = $curl->simulate();
		# if ($data) {
			echo \Ext\Filesystem::putContents($url, $data ? : 'timeout', 'not overwrite');
			exit;
		# }

		// 失败
		return ['url' => $arg_url];
	}
}

