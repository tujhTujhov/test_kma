<?php

namespace ESemenkov\TestTaskKma\repositories;

use ClickHouseDB\Client;
use ESemenkov\TestTaskKma\models\Url;
use PDO;


class UrlRepository
{
    private \PDO $PDO;
    private Client $ch;

    public function __construct()
    {
        $config = require __DIR__ . "/../config/config.php";
        $this->PDO = new PDO(
            sprintf("mysql:host=%s;dbname=%s;port=%d",
                $config['mariadb']['host'],
                $config['mariadb']['dbname'],
                $config['mariadb']['port']
            ),
            $config['mariadb']['user'],
            $config['mariadb']['password']
        );

        $this->ch = new Client($config['clickhouse']);
        $this->ch->database($config['clickhouse']['dbname']);
    }

    public function insertUrlIntoMaria(Url $url)
    {
        $query = sprintf("
            INSERT INTO urls 
            (url, created_time, content_length)
            VALUES ( '%s', '%d', '%d');
        ",
            $url->url,
            $url->time,
            $url->contentLength
        );

        if (!$this->PDO->exec($query)) {
            error_log("cannot save URL. url={{ $url->url }}");
        }
    }

    public function getUrls()
    {
        $query = "
            SELECT
                DATE_FORMAT(FROM_UNIXTIME(created_time), '%Y-%m-%d %H:%i') AS Minute,
                AVG(content_length) AS AvgContentLength,
                COUNT(*) AS RowCount,
                MIN(FROM_UNIXTIME(created_time)) AS FirstReceivedTime,
                MAX(FROM_UNIXTIME(created_time)) AS LastReceivedTime
            FROM
                urls
            WHERE
                FROM_UNIXTIME(created_time) >= NOW() - INTERVAL 10 MINUTE
            GROUP BY
                Minute
            ORDER BY
                Minute;
        ";
        $stmt = $this->PDO->query($query);
        return $stmt->fetchAll();
    }

    public function insertUrlIntoCh(Url $url)
    {
        $query = sprintf("
            INSERT INTO urls 
            (url, time, content_length)
            VALUES ( '%s', '%d', '%d'), 
        ",
            $url->url,
            $url->time,
            $url->contentLength
        );

        if (!$this->ch->exec($query)) {
            error_log("cannot save URL. url={{ $url->url }}");
        }
    }

}