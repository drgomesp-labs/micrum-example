<?php declare(strict_types=1);

namespace Mercur\Payment\Event\Adyen;

use Mercur\Messaging\DomainEvent;
use Money\Money;

/**
 * Class NotificationReceivedEvent
 *
 * @package Mercur\Payment\Event\Adyen
 */
final class NotificationReceivedEvent extends DomainEvent
{
	/**
	 * @var Money
	 */
	private $amount;

	/**
	 * @return Money
	 */
	public function amount(): Money
	{
		if (empty($this->amount)) {
			$this->amount = Money::EUR($this->amount);
		}

		return $this->amount;
	}

	/**
	 * @param int $amount
	 *
	 * @return NotificationReceivedEvent
	 */
	public function withAmount(int $amount): self
	{
		$clone = clone $this;
		$clone->amount = Money::EUR($amount);

		return $clone;
	}
}
