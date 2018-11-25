<?php declare(strict_types=1);

namespace Mercur\EventSourcing\Traits;

use Mercur\EventSourcing\EventStream;
use Mercur\EventSourcing\EventStream\InMemoryEventStream;

/**
 * Trait EventSourcing
 *
 * @package Mercur\EventSourcing\Traits
 */
trait EventSourcing
{
	/**
	 * @var array
	 */
	protected $uncommittedEvents;

	protected $version = 0;

	/**
	 * @return EventStream
	 */
	public function uncommittedEvents(): EventStream
	{
		$stream = new InMemoryEventStream($this->uncommittedEvents);

		$this->uncommittedEvents = [];

		return $stream;
	}
}
