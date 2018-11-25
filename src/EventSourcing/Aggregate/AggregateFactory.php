<?php declare(strict_types=1);

namespace Mercur\EventSourcing\Aggregate;

use Mercur\EventSourcing\Aggregate;
use Mercur\EventSourcing\EventStream;

/**
 * Interface AggregateFactory
 *
 * @package Mercur\EventSourcing\Aggregate\Factory
 */
interface AggregateFactory
{
	/**
	 *
	 * @param string                            $aggregateClassName
	 * @param \Mercur\EventSourcing\EventStream $events
	 *
	 * @return \Mercur\EventSourcing\Aggregate
	 */
	public function create(string $aggregateClassName, EventStream $events): Aggregate;
}
