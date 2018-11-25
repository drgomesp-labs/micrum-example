<?php declare(strict_types=1);

namespace Mercur\Payment\Event;

use Mercur\Messaging\DomainEvent;
use Money\Money;

/**
 * Class PaymentReceived
 *
 * @package Mercur\Payment\Event
 */
class PaymentReceived extends DomainEvent
{
	/**
	 * @var Money
	 */
	protected $amount;

	/**
	 * PaymentReceived constructor.
	 *
	 * @param int $amount
	 *
	 * @return self
	 * @throws \Exception
	 */
	public static function withAmount(int $amount): self
	{
		/** @var self $clone */
		$clone = self::occur(['amount' => $amount]);

		return $clone;
	}

	/**
	 * @return Money
	 */
	public function amount(): Money
	{
		return $this->amount ?? $this->amount = Money::EUR($this->amount);
	}
}
