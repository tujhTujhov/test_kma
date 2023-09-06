<?php

return [
    'mariadb' => [
        'host' => 'test-task-kma-mariadb',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'dbname' => 'test_kma'
    ],
    'clickhouse' => [
        'host' => 'test-task-kma-ch',
        'port' => 9000,
        'username' => '',
        'password' => '',
        'dbname' => '',
    ],
    'rmq' => [
        'host' => 'test-task-kma-rmq',
        'port' => 5672,
        'user' => 'esemenkov',
        'password' => '123456',
        'exchange' => 'default',
        'queue_name' => 'msg_urls_queue'
    ],
];