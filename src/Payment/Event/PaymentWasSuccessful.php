<?php declare(strict_types=1);

namespace Mercur\Payment\Event;

use Mercur\Messaging\DomainEvent;
use Money\Money;

/**
 * Class PaymentWasSuccessful
 *
 * @package Mercur\Payment\Event
 */
class PaymentWasSuccessful extends DomainEvent
{
	/**
	 * @var Money
	 */
	protected $amount;

	/**
	 * PaymentWasSuccessful constructor.
	 *
	 * @param int $amount
	 *
	 * @return self
	 * @throws \Exception
	 */
	public function with(int $amount): self
	{
		/** @var self $clone */
		$clone = self::occur(['amount' => $amount]);

		return $clone;
	}

	/**
	 * @return Money
	 */
	public function getAmount(): Money
	{
		if (empty($this->amount)) {
			$this->amount = Money::EUR($this->amount);
		}

		return $this->amount;
	}
}
