<?php
define('APP_PATH', __DIR__);
# define('VENDOR_DIR', 'C:/Users/Administrator/AppData/Local/Composer/files');


$_CONFIG = require __DIR__ . '/config.php';

/**
 * 包含赋值类文件加载器对象
 *
 * 声明函数库

$autoload = require $_CONFIG['autoload']['file'];
$anfora = new \Anfora;
 */

$ClassLoader = require APP_PATH . '/../vendor/autoload.php';
