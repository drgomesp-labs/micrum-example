<?php declare(strict_types=1);

namespace Mercur\Payment\Event\Adyen;

/**
 * Class NotificationReceivedEvent
 *
 * @package Mercur\Payment\Event\Adyen
 */
final class NotificationReceivedEvent
{
	/**
	 * @var array
	 */
	private $payload;

	/**
	 * NotificationReceivedEvent constructor.
	 *
	 * @param array $payload
	 */
	public function __construct(array $payload)
	{
		$this->payload = $payload;
	}
}
