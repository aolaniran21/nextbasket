<?php

namespace App\Services;

require_once __DIR__ . '/../Services/RabbitMQService.php';

use App\Services\RabbitMQService;

class NotificationService
{
    public function __construct()
    {
        // Subscribe to the event queue
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->subscribeToQueue('data.submitted', [$this, 'handleDataSubmission']);

        // echo $rabbitMQService;
    }

    public function handleDataSubmission($msg)
    {
        // Process the received message
        $data = json_decode($msg->body, true);
        define('WRITEPATHs', '/var/www/htdocs/nextbasket-test/notification/writable/');
        // Save the data to a log file
        $logData = date('Y-m-d H:i:s') . ': ' . json_encode($data) . PHP_EOL;
        file_put_contents(WRITEPATHs . 'logs/notification.log', $logData, FILE_APPEND);
    }
}


// $n = new NotificationService();
