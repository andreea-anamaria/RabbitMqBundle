<?php

namespace OldSound\RabbitMqBundle\Tests\Event;

use OldSound\RabbitMqBundle\Event\OnIdleEvent;
use OldSound\RabbitMqBundle\RabbitMq\Consumer;
use PHPUnit\Framework\TestCase;

/**
 * Class OnIdleEventTest
 *
 * @package OldSound\RabbitMqBundle\Tests\Event
 */
class OnIdleEventTest extends TestCase
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

    public function testShouldAllowGetConsumerSetInConstructor(): void
    {
        $consumer = $this->getConsumer();
        $event = new OnIdleEvent($consumer);

        $this->assertSame($consumer, $event->getConsumer());
    }

    public function testShouldSetForceStopToTrueInConstructor(): void
    {
        $consumer = $this->getConsumer();
        $event = new OnIdleEvent($consumer);

        $this->assertTrue($event->isForceStop());
    }

    public function testShouldReturnPreviouslySetForceStop(): void
    {
        $consumer = $this->getConsumer();
        $event = new OnIdleEvent($consumer);

        //guard
        $this->assertTrue($event->isForceStop());

        $event->setForceStop(false);
        $this->assertFalse($event->isForceStop());
    }
}
