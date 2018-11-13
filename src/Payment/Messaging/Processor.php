<?php declare(strict_types=1);

namespace Mercur\Payment\Messaging;

use Enqueue\Client\TopicSubscriberInterface;
use Interop\Queue\Context;
use Interop\Queue\Message;

/**
 * Class Processor
 *
 * @package Mercur\Payment\Messaging
 */
class Processor implements \Interop\Queue\Processor, TopicSubscriberInterface
{
	public function process(Message $message, Context $context)
	{
		var_dump($message);
		exit;
		return self::ACK;
	}

	public static function getSubscribedTopics()
	{
		return ['adyen_events'];
	}
}
