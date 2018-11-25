<?php declare(strict_types=1);

namespace Mercur\EventSourcing;

use Mercur\EventSourcing\Aggregate\DomainEventMessage;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface Aggregate
 *
 * @package Mercur\EventSourcing
 */
interface Aggregate
{
	/**
	 *
	 *
	 * @return Uuid
	 */
	public function id(): UuidInterface;

	/**
	 *
	 *
	 * @param \Mercur\EventSourcing\EventStream $events
	 *
	 * @return \Mercur\EventSourcing\Aggregate
	 */
	public function reconstituteFromHistory(EventStream $events): self;

	/**
	 * @param DomainEventMessage $eventMessage
	 *
	 * @return Aggregate
	 */
	public function apply(DomainEventMessage $eventMessage): self;

	/**
	 *
	 *
	 * @return EventStream
	 */
	public function uncommittedEvents(): EventStream;

	/**
	 * @return int
	 */
	public function version(): int;
}
