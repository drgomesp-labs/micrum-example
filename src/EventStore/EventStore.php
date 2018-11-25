<?php declare(strict_types=1);

namespace Mercur\EventStore;

use Mercur\EventSourcing\EventStream;

/**
 * Interface EventStore
 *
 * @package Mercur\EventStore
 */
interface EventStore
{
	/**
	 *
	 *
	 * @param string      $aggregateId
	 * @param EventStream $events
	 */
	public function append(string $aggregateId, EventStream $events): void;

	/**
	 *
	 *
	 * @param string $aggregateId
	 *
	 * @return \Mercur\EventSourcing\EventStream
	 */
	public function read(string $aggregateId): EventStream;
}
