<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory\Exception;

/**
 * Class UnknownCommandException
 *
 * @package Mercur\Messaging\Factory\Exception
 */
class UnknownCommandException extends \RuntimeException
{
	/**
	 * @param string $commandName
	 *
	 * @return UnknownCommandException
	 */
	public static function withCommandName(string $commandName): self
	{
		return new self(sprintf('Mapping for command with name "%s" could not be found.', $commandName));
	}

	/**
	 * @param string $commandClassName
	 *
	 * @return UnknownCommandException
	 */
	public static function withCommandClassName(string $commandClassName): self
	{
		return new self(sprintf('Command class with name "%s" could not be found.', $commandClassName));
	}
}
