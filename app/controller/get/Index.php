<?php

namespace app\controller\get;

use Astro\Ext\PhpCurl;

class Index extends \Astro\Controller
{
	public function index()
	{
		$url = 'http://open.urlnk.com/s?debug';
		$url = 'http://api.lan.urlnk.com/v1/git/hooks?debug';
		$data = "key=value&k=v";
		$curl = new PhpCurl($url);
		$result = $curl->request($data, 'post');
		echo "<textarea>$result</textarea>";
		# print_r([$result, __METHOD__, __LINE__, __FILE__]);
	}
}

