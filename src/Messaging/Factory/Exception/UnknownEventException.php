<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory\Exception;

/**
 * Class UnknownEventException
 *
 * @package Mercur\Messaging\Factory\Exception
 */
class UnknownEventException extends \RuntimeException
{
	/**
	 * @param string $eventName
	 *
	 * @return UnknownEventException
	 */
	public static function withEventName(string $eventName): self
	{
		return new self(sprintf('Mapping for event with name "%s" could not be found.', $eventName));
	}

	/**
	 * @param string $eventClassName
	 *
	 * @return UnknownEventException
	 */
	public static function withEventClassName(string $eventClassName): self
	{
		return new UnknownEventException(sprintf('Event class with name "%s" could not be found.', $eventClassName));
	}
}
