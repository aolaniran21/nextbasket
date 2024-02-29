<?php

namespace App\Libraries\RabbitMQ;

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQ
{
    public static function getConnection()
    {
        return new AMQPStreamConnection(
            'localhost', // RabbitMQ server host
            5672,        // RabbitMQ server port
            'guest',     // Username
            'guest'      // Password
        );
    }
}
