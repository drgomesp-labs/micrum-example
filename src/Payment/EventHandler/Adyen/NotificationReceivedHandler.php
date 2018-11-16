<?php declare(strict_types=1);

namespace Mercur\Payment\EventHandler\Adyen;

use Mercur\Payment\Event\Adyen\NotificationReceivedEvent;
use Mercur\Payment\Event\PaymentWasSuccessful;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class NotificationReceivedHandler
 *
 * @package Mercur\Payment\EventHandler\Adyen
 */
class NotificationReceivedHandler implements MessageHandlerInterface
{
	/**
	 * @var MessageBusInterface
	 */
	private $eventBus;

	/**
	 * NotificationReceivedHandler constructor.
	 *
	 * @param MessageBusInterface $eventBus
	 */
	public function __construct(MessageBusInterface $eventBus)
	{
		$this->eventBus = $eventBus;
	}

	/**
	 * @param NotificationReceivedEvent $event
	 *
	 * @throws \Exception
	 */
	public function __invoke(NotificationReceivedEvent $event): void
	{
		$this->eventBus->dispatch(PaymentWasSuccessful::occur(['amount' => 333]));
	}
}
