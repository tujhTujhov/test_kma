<?php

require 'vendor/autoload.php';
use ESemenkov\TestTaskKma\helpers\QueueHelper;

$urls = [
    'https://habr.com/ru/articles/759230/',
    'https://www.google.co.uk/search?q=dogs',
    'https://yandex.com/search/?text=cats',
    'https://example.com/page123',
    'https://www.php.net/downloads',
    'https://github.com/torvalds',
    'https://t.me/tujhtujhov',
    'https://go.dev/play/',
    'https://onlinephp.io/',
    'https://www.linkedin.com/mynetwork/'
];

$queueHelper = new QueueHelper();
foreach ($urls as $url) {
    sleep(rand(5, 30));
    $queueHelper->publishUrl($url);
    echo "message $url sent to queue\n";
}



