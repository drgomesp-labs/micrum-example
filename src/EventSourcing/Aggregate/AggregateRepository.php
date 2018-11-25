<?php declare(strict_types=1);

namespace Mercur\EventSourcing\Aggregate;

use Mercur\EventSourcing\Aggregate;

/**
 * Interface AggregateRepository
 *
 * @package Mercur\EventSourcing\Aggregate
 */
interface AggregateRepository
{
	/**
	 *
	 *
	 * @param string $aggregateId
	 *
	 * @return \Mercur\EventSourcing\Aggregate
	 */
	public function load(string $aggregateId): Aggregate;

	/**
	 *
	 *
	 * @param \Mercur\EventSourcing\Aggregate $aggregate
	 */
	public function save(Aggregate $aggregate): void;
}
