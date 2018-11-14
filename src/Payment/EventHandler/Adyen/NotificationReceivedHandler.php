<?php declare(strict_types=1);

namespace Mercur\Payment\EventHandler\Adyen;

use Enqueue\Client\ProducerInterface;
use Mercur\Payment\Event\Adyen\NotificationReceivedEvent;
use Mercur\Payment\Event\PaymentWasSuccessful;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class NotificationReceivedHandler
 *
 * @package Mercur\Payment\EventHandler\Adyen
 */
class NotificationReceivedHandler implements MessageHandlerInterface
{
	/**
	 * @var ProducerInterface
	 */
	private $producer;

	/**
	 * NotificationReceivedHandler constructor.
	 *
	 * @param ProducerInterface $producer
	 */
	public function __construct(ProducerInterface $producer)
	{
		$this->producer = $producer;
	}

	/**
	 * @param NotificationReceivedEvent $event
	 *
	 * @throws \Exception
	 */
	public function __invoke(NotificationReceivedEvent $event): void
	{
		$this->producer->sendEvent('adyen_events', PaymentWasSuccessful::occur(['amount' => 333]));
	}
}
