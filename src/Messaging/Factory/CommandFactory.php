<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory;

use Mercur\Messaging\Factory\Exception\UnknownCommandException;

/**
 * Class CommandFactory
 *
 * @package Mercur\Messaging\Factory
 */
final class CommandFactory
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

	/**
	 * @param string $commandName
	 * @param array  $payload
	 *
	 * @return mixed
	 *
	 * @throws UnknownCommandException
	 */
	public function create(string $commandName, array $payload)
	{
		if (!isset($this->mappings[$commandName])) {
			throw UnknownCommandException::withCommandName($commandName);
		}

		$commandClassName = $this->mappings[$commandName];

		if (!class_exists($commandClassName)) {
			throw UnknownCommandException::withCommandName($commandClassName);
		}

		return new $commandClassName($payload);
	}
}
