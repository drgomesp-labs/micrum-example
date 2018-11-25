<?php declare(strict_types=1);

namespace Mercur\EventStore;

use Mercur\EventSourcing\EventMessage;
use Mercur\EventSourcing\EventStream;
use Mercur\EventSourcing\EventStream\Exception\EventStreamNotFoundException;
use Mercur\EventSourcing\EventStream\InMemoryEventStream;

/**
 * Class InMemoryEventStore
 *
 * @package Mercur\EventStore
 */
class InMemoryEventStore implements EventStore
{
	/**
	 * @var EventMessage[]
	 */
	private $events = [];

	/**
	 * InMemoryEventStore constructor.
	 *
	 * @param array $events
	 */
	public function __construct(array $events = [])
	{
		$this->events = $events;
	}

	public function append(string $aggregateId, EventStream $events): void
	{
		if (!isset($this->events[$aggregateId])) {
			$this->events[$aggregateId] = [];
		}

		/** @var EventMessage $event */
		foreach ($events as $event) {
			// TODO: get the event version as a key here
			$this->events[$aggregateId][] = $event;
		}
	}

	public function read(string $aggregateId): EventStream
	{
		if (isset($this->events[$aggregateId])) {
			return new InMemoryEventStream($this->events[$aggregateId]);
		}

		throw new EventStreamNotFoundException();
	}
}
