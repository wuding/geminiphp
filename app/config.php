<?php
return [
    'route' => [
        [['GET', 'POST', 'PUT'], '/s', 'all:search/index/index'],
        [['GET', 'POST', 'PUT'], '/[index]', '/index/index'],
        ['GET', '/user/{id:\d+}', 'get_user_handler'],
        ['GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler'],
    ],
];
