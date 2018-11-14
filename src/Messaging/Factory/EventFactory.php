<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory;

use Mercur\Messaging\DomainEvent;
use Mercur\Messaging\Factory\Exception\EventRaisingException;
use Mercur\Messaging\Factory\Exception\InvalidEventClassException;
use Mercur\Messaging\Factory\Exception\UnknownEventException;
use Mercur\Messaging\Message\Payload;

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
	 * @param array  $headers
	 *
	 * @return mixed
	 *
	 * @throws UnknownEventException
	 */
	public function create(string $eventName, array $payload, array $headers = [])
	{
		if (!isset($this->mappings[$eventName])) {
			throw UnknownEventException::withEventName($eventName);
		}

		$eventClassName = $this->mappings[$eventName];

		if (!class_exists($eventClassName)) {
			throw UnknownEventException::withEventClassName($eventClassName);
		}

		if (!is_subclass_of($eventClassName, DomainEvent::class, true)) {
			throw InvalidEventClassException::withEventClassName($eventClassName);
		}

		try {
			return forward_static_call([$eventClassName, 'occur'], $payload, ['_headers' => $headers]);
		} catch (\Throwable $e) {
			throw new EventRaisingException('Could not raise event', 0, $e);
		}
	}
}
