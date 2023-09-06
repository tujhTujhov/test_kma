<?php

namespace ESemenkov\TestTaskKma\helpers;

use ESemenkov\TestTaskKma\models\Url;
use ESemenkov\TestTaskKma\repositories\UrlRepository;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class QueueHelper
{
    private AbstractChannel|AMQPChannel $channel;
    private AMQPStreamConnection $conn;
    private string $exchange;
    private string $queueName;
    public function __construct()
    {
        $conf = require __DIR__ . "/../config/config.php";
        try {
            $this->conn = new AMQPStreamConnection(
                $conf['rmq']['host'],
                $conf['rmq']['port'],
                $conf['rmq']['user'],
                $conf['rmq']['password'],
            );
        } catch (\Exception $e) {
            error_log("Couldnt create RMQ connection");
            error_log($e->getMessage());
            die();
        }
        echo "Connected o RMQ\n";
        $this->exchange = $conf['rmq']['exchange'];
        $this->queueName = $conf['rmq']['queue_name'];
        $this->channel = $this->conn->channel();
        $this->channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT);
        $this->channel->queue_declare($this->queueName, false, true, false, false);
        $this->channel->queue_bind($this->queueName, $this->exchange, 'default_routing_key');
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->conn->close();
    }

    public function publishUrl(string $url){
        $message = new AMQPMessage($url, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        $this->channel->basic_publish($message, $this->exchange, 'default_routing_key');
    }

    public function consume()
    {
        $repo = new UrlRepository();
        $msg = $this->channel->basic_consume(
            $this->queueName,
            'consumer',
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) use ($repo) {
                echo "message received\n";
                $url = new Url(
                    $message->body,
                    time(),
                    strlen($message->body)
                );
                $repo->insertUrlIntoMaria($url);
                $message->ack();
                //$repo->insertUrlIntoCh($url);
            }
        );

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
    }
}