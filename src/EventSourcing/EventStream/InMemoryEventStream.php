<?php declare(strict_types=1);

namespace Mercur\EventSourcing\EventStream;

use Mercur\EventSourcing\EventMessage;
use Mercur\EventSourcing\EventStream;

/**
 * Class InMemoryEventStream
 *
 * @package Mercur\EventSourcing\EventStream
 */
final class InMemoryEventStream implements EventStream
{
	/**
	 * @var array
	 */
	private $events;

	/**
	 * InMemoryEventStream constructor.
	 *
	 * @param array $events
	 */
	public function __construct(array $events)
	{
		$this->events = $events;
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->events);
	}

	public function of(EventStream $stream): EventStream
	{
		$this->events = iterator_to_array($stream);

		return $this;
	}

	public function empty(): EventStream
	{
		return new self([]);
	}

	public function next(): ?EventMessage
	{
		return $this->getIterator()->next();
	}
}
