<?php

namespace App\Services;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Libraries/RabbitMQ.php';

use PhpAmqpLib\Message\AMQPMessage;
use App\Libraries\RabbitMQ\RabbitMQ;

class RabbitMQService
{
    public $channel;

    public function __construct()
    {
        $connection = RabbitMQ::getConnection();
        $this->channel = $connection->channel();
    }

    public function publishMessage($queueName, $message)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function subscribeToQueue($queueName, $callback)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function close()
    {
        $this->channel->close();
    }

    public function __destruct()
    {
        $this->close();
    }
}


// $d = new RabbitMQService();
// $ch = $d->channel;

// echo json_encode($ch);
