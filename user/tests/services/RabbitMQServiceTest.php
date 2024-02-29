<?php

namespace App\Tests\Services;

require_once __DIR__ . '/../../app/Services/RabbitMQService.php';


use App\Services\RabbitMQService;
use PHPUnit\Framework\TestCase;

class RabbitMQServiceTest extends TestCase
{
    public function testPublishMessage()
    {
        $service = new RabbitMQService();

        // Mock RabbitMQ channel (optional)
        $channelMock = $this->getMockBuilder('\PhpAmqpLib\Channel\AMQPChannel')
            ->disableOriginalConstructor()
            ->getMock();

        $service->channel = $channelMock;

        $queueName = 'test_queue';
        $message = 'Test message';

        // Assert that queue_declare is called with correct arguments
        $channelMock->expects($this->once())
            ->method('queue_declare')
            ->with($this->equalTo($queueName), $this->equalTo(false), $this->equalTo(true), $this->equalTo(false), $this->equalTo(false));

        // Assert that basic_publish is called with correct arguments
        $channelMock->expects($this->once())
            ->method('basic_publish')
            ->with($this->callback(function ($arg) use ($message) {
                return $arg instanceof \PhpAmqpLib\Message\AMQPMessage && $arg->getBody() === $message;
            }), $this->equalTo(''), $this->equalTo($queueName));

        $service->publishMessage($queueName, $message);
    }

    // Similarly, you can write test cases for other methods like subscribeToQueue
    // Remember to mock the RabbitMQ channel if necessary
}
