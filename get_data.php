<?php
require 'vendor/autoload.php';

$repo = new \ESemenkov\TestTaskKma\repositories\UrlRepository();
$dataPerMinute = $repo->getUrls();

foreach ($dataPerMinute as $item) {
    echo sprintf("
    Минута: %s\n 
    Средняя длина сообщения: %s\n 
    Время первого сообщения в минуте: %s\n
    Время последнего сообщения в минуте: %s\n
    ___________
    ",
        $item['Minute'],
        $item['AvgContentLength'],
        $item['FirstReceivedTime'],
        $item['LastReceivedTime']
    );
}
