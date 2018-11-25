<?php declare(strict_types=1);

namespace Mercur\EventSourcing\Aggregate\Repository;

use Mercur\EventSourcing\Aggregate;
use Mercur\EventSourcing\Aggregate\AggregateRepository;
use Mercur\EventSourcing\EventStream\InMemoryEventStream;
use Mercur\EventStore\EventStore;

/**
 * Class InMemoryAggregateRepository
 *
 * @package Mercur\EventSourcing\Aggregate\Repository
 */
final class InMemoryAggregateRepository implements AggregateRepository
{
	/**
	 * @var \Mercur\EventStore\EventStore
	 */
	private $eventStore;

	/**
	 * @var \Mercur\EventSourcing\Aggregate\AggregateFactory
	 */
	private $aggregateFactory;

	/**
	 * @var string
	 */
	private $aggregateClassName;

	/**
	 * InMemoryAggregateRepository constructor.
	 *
	 * @param \Mercur\EventStore\EventStore                    $eventStore
	 * @param \Mercur\EventSourcing\Aggregate\AggregateFactory $aggregateFactory
	 * @param string                                           $aggregateClassName
	 */
	public function __construct(
		EventStore $eventStore,
		Aggregate\AggregateFactory $aggregateFactory,
		string $aggregateClassName
	) {
		$this->eventStore = $eventStore;
		$this->aggregateFactory = $aggregateFactory;
		$this->aggregateClassName = $aggregateClassName;
	}

	public function load(string $aggregateId): Aggregate
	{
		printf('load("%s")' . PHP_EOL, $aggregateId);

		$eventStream = $this->eventStore->read($aggregateId);
		return $this->aggregateFactory->create($this->aggregateClassName, $eventStream);
	}

	public function save(Aggregate $aggregate): void
	{
		printf('save("%s")' . PHP_EOL, $aggregate->id());

		$stream = (new InMemoryEventStream([]))->of($aggregate->uncommittedEvents());
		$this->eventStore->append((string)$aggregate->id(), $stream);
	}
}
