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

    public function testSubscribeToQueue()
    {
        // Mock the callback function
        $callbackMock = function ($msg) {
            // Mock callback logic here if needed
        };

        // Mock RabbitMQ channel
        $channelMock = $this->getMockBuilder('\PhpAmqpLib\Channel\AMQPChannel')
            ->disableOriginalConstructor()
            ->getMock();

        // Mock channel methods
        $channelMock->expects($this->once())
            ->method('queue_declare');

        $channelMock->expects($this->once())
            ->method('basic_consume');

        $channelMock->expects($this->once())
            ->method('is_consuming')
            ->willReturn(false); // To exit the loop immediately

        // Create instance of RabbitMQService and inject mocked channel
        $service = new RabbitMQService();
        $service->channel = $channelMock;

        // Call the subscribeToQueue method
        $queueName = 'test_queue';
        $service->subscribeToQueue($queueName, $callbackMock);
    }
}
