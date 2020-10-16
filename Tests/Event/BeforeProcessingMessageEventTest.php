<?php

namespace OldSound\RabbitMqBundle\Tests\Event;

use OldSound\RabbitMqBundle\Event\BeforeProcessingMessageEvent;
use OldSound\RabbitMqBundle\RabbitMq\Consumer;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;

/**
 * Class BeforeProcessingMessageEventTest
 *
 * @package OldSound\RabbitMqBundle\Tests\Event
 */
class BeforeProcessingMessageEventTest extends TestCase
{
    protected function getConsumer(): Consumer
    {
        return new Consumer(
            $this->getMockBuilder('\PhpAmqpLib\Connection\AMQPConnection')
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder('\PhpAmqpLib\Channel\AMQPChannel')
                ->disableOriginalConstructor()
                ->getMock()
        );
    }

    public function testEvent(): void
    {
        $AMQPMessage = new AMQPMessage('body');
        $consumer = $this->getConsumer();
        $event = new BeforeProcessingMessageEvent($consumer, $AMQPMessage);
        $this->assertSame($AMQPMessage, $event->getAMQPMessage());
        $this->assertSame($consumer, $event->getConsumer());
    }
}
