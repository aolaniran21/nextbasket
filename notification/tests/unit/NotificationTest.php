<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/Services/NotificatonService.php';

use App\Services\NotificationService;

class NotificationServiceTest extends TestCase
{
    public function testHandleDataSubmission()
    {


        // Create an instance of the NotificationService
        $notificationService = new NotificationService();
    }
}
