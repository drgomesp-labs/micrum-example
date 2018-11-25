<?php declare(strict_types=1);

namespace Mercur\EventStore\Engine;

use Mercur\EventSourcing\EventMessage;
use Mercur\EventSourcing\EventStream;
use Mercur\EventSourcing\EventStream\InMemoryEventStream;
use Mercur\EventStore\EventStoreEngine;

/**
 * Class InMemoryEventStoreEngine
 *
 * @package Mercur\EventStore\Engine
 */
class InMemoryEventStoreEngine implements EventStoreEngine
{
	/**
	 * @var EventStream
	 */
	private $events;

	/**
	 * InMemoryEventStoreEngine constructor.
	 *
	 * @param EventStream $events
	 */
	public function __construct(EventStream $events = null)
	{
		$this->events = $events ?? new InMemoryEventStream([]);
	}

	public function append(EventMessage ...$eventMessage): void
	{
		$this->events->of(new InMemoryEventStream($eventMessage));
	}

	public function read(bool $blockToWait = false): EventStream
	{
		return $this->events;
	}
}
