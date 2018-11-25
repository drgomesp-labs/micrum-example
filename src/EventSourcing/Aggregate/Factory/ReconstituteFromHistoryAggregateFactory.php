<?php declare(strict_types=1);

namespace Mercur\EventSourcing\Aggregate\Factory;

use Mercur\EventSourcing\Aggregate;
use Mercur\EventSourcing\Aggregate\AggregateFactory;
use Mercur\EventSourcing\Aggregate\Factory\Exception\InvalidAggregateTypeException;
use Mercur\EventSourcing\EventStream;

/**
 * Class ReconstituteFromHistoryAggregateFactory
 *
 * @package Mercur\EventSourcing\Aggregate\Factory
 */
class ReconstituteFromHistoryAggregateFactory implements AggregateFactory
{
	public function create(string $aggregateClassName, EventStream $events): Aggregate
	{
		$aggregate = new $aggregateClassName;

		if (!$aggregate instanceof Aggregate) {
			throw new InvalidAggregateTypeException(sprintf(
					'Aggregate of type "%s" must implement "%s" interface.',
					get_class($aggregate),
					Aggregate::class)
			);
		}

		return $aggregate->reconstituteFromHistory($events);
	}
}
