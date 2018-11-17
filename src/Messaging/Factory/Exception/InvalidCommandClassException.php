<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory\Exception;

use Mercur\Messaging\DomainEvent;

/**
 * Class InvalidCommandClassException
 *
 * @package Mercur\Messaging\Factory\Exception
 */
class InvalidCommandClassException extends \RuntimeException
{
	/**
	 * @param string $commandClassName
	 *
	 * @return self
	 */
	public static function withCommandClassName(string $commandClassName): self
	{
		return new self(
			sprintf('Command class with name "%s" must extend "%s".', $commandClassName, DomainEvent::class)
		);
	}
}
