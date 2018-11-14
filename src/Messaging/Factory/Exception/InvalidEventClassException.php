<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory\Exception;

use Mercur\Messaging\DomainEvent;

/**
 * Class InvalidEventClassException
 *
 * @package Mercur\Messaging\Factory\Exception
 */
class InvalidEventClassException extends \RuntimeException
{
	/**
	 * @param string $eventClassName
	 *
	 * @return self
	 */
	public static function withEventClassName(string $eventClassName): self
	{
		return new self(sprintf('Event class with name "%s" must extend "%s".', $eventClassName, DomainEvent::class));
	}
}
