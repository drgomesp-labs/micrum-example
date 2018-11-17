<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory;

use Mercur\Messaging\CommandMessage;
use Mercur\Messaging\Factory\Exception\InvalidCommandClassException;
use Mercur\Messaging\Factory\Exception\UnknownCommandException;
use Mercur\Messaging\Message;
use Mercur\Messaging\Message\Payload;

/**
 * Class CommandFactory
 *
 * @package Mercur\Messaging\Factory
 */
final class CommandFactory implements MessageFactory
{
	/**
	 * @var array
	 */
	private $mappings;

	/**
	 * CommandFactory constructor.
	 *
	 * @param array $mappings
	 */
	public function __construct(array $mappings)
	{
		$this->mappings = $mappings;
	}

	public function create(string $messageClassName, array $payload, array $headers = []): Message
	{
		if (!isset($this->mappings[$messageClassName])) {
			throw UnknownCommandException::withCommandName($messageClassName);
		}

		$commandClassName = $this->mappings[$messageClassName];

		if (!class_exists($commandClassName)) {
			throw UnknownCommandException::withCommandClassName($commandClassName);
		}

		if (!is_subclass_of($commandClassName, CommandMessage::class, true)) {
			throw InvalidCommandClassException::withCommandClassName($commandClassName);
		}

		return new $commandClassName(Payload::fromArray($payload));
	}
}
