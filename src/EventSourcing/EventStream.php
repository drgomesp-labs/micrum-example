<?php declare(strict_types=1);

namespace Mercur\EventSourcing;

/**
 * Interface EventStream
 *
 * @package Mercur\EventStore
 */
interface EventStream extends \IteratorAggregate
{
	/**
	 * @param \Mercur\EventSourcing\EventStream $stream
	 *
	 * @return \Mercur\EventSourcing\EventStream
	 */
	public function of(EventStream $stream): EventStream;

	/**
	 * @return \Mercur\EventSourcing\EventStream
	 */
	public function empty(): EventStream;

	/**
	 * @return \Mercur\EventSourcing\EventMessage|null
	 */
	public function next(): ?EventMessage;
}
