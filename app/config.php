<?php

/**
 * 项目固定绝对唯一目录
 */
defined('BASE_DIR') or define('BASE_DIR', __DIR__ . '/..');
# define('VENDOR_DIR', __DIR__ . '/../vendor');
defined('VENDOR_DIR') or define('VENDOR_DIR', 'C:/Users/Administrator/AppData/Local/Composer/files');
defined('COMPOSER_JSON') or define('COMPOSER_JSON', realpath(BASE_DIR . '/composer.json'));
defined('HHVM_VERSION') or define('HHVM_VERSION', '-1');

return [
    'route' => [
        [['GET', 'POST', 'PUT'], '/s', 'all:search/index/index'],
        [['GET', 'POST', 'PUT'], '/[index]', '/index/index'],
        ['GET', '/user/{id:\d+}', 'get_user_handler'],
        ['GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler'],
        ['GET', '/my.ini', 'configuration/mysql/index'],
        [['GET', 'POST'], '/php.ini', 'configuration/php/index'],
    ],
    'autoload' => [
        'file' => 'E:/env/www/work/wuding/anfora/src/autoload.php',
        'php-ext' => 'E:/env/www/work/wuding/php-ext/src',
    ],
    'debug' => [
        'file' => 0,
    ],
    'cache' => [
        'web' => 'E:/env/www/legend/dist',
    ]
];
