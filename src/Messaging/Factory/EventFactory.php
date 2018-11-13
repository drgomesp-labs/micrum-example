<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory;

use Mercur\Messaging\Factory\Exception\UnknownEventException;

/**
 * Class EventFactory
 *
 * @package Mercur\Messaging\Factory
 */
final class EventFactory
{
	/**
	 * @var array
	 */
	private $mappings;

	/**
	 * EventFactory constructor.
	 *
	 * @param array $mappings
	 */
	public function __construct(array $mappings)
	{
		$this->mappings = $mappings;
	}

	/**
	 * @param string $eventName
	 * @param array  $payload
	 *
	 * @return mixed
	 *
	 * @throws UnknownEventException
	 */
	public function create(string $eventName, array $payload)
	{
		if (!isset($this->mappings[$eventName])) {
			throw UnknownEventException::withEventName($eventName);
		}

		$eventClassName = $this->mappings[$eventName];

		if (!class_exists($eventClassName)) {
			throw UnknownEventException::withEventClassName($eventClassName);
		}

		return new $eventClassName($payload);
	}
}
