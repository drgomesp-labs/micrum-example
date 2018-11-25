<?php declare(strict_types=1);

namespace Mercur\EventStore;

use Mercur\EventSourcing\EventMessage;
use Mercur\EventSourcing\EventStream;

/**
 * Interface EventStoreEngine
 *
 * @package Mercur\EventStore
 */
interface EventStoreEngine
{
	/**
	 *
	 *
	 * @param EventMessage ...$eventMessage
	 */
	public function append(EventMessage ...$eventMessage): void;

	/**
	 *
	 *
	 * @param bool $blockToWait
	 *
	 * @return \Mercur\EventSourcing\EventStream
	 */
	public function read(bool $blockToWait = false): EventStream;
}
