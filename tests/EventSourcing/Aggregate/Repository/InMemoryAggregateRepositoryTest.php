<?php declare(strict_types=1);

namespace Mercur\Tests\EventSourcing\Aggregate\Repository;

use Mercur\EventSourcing\Aggregate;
use Mercur\EventSourcing\Aggregate\Factory\ReconstituteFromHistoryAggregateFactory;
use Mercur\EventSourcing\Aggregate\Repository\InMemoryAggregateRepository;
use Mercur\EventSourcing\EventStream;
use Mercur\EventSourcing\EventStream\InMemoryEventStream;
use Mercur\EventStore\InMemoryEventStore;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InMemoryAggregateRepositoryTest
 *
 * @package Mercur\Tests\EventSourcing\Aggregate\Repository
 */
class InMemoryAggregateRepositoryTest extends TestCase
{
	/**
	 * @test
	 */
	public function it_can_load_aggregate()
	{
		$repository = new InMemoryAggregateRepository(
			new InMemoryEventStore(),
			new ReconstituteFromHistoryAggregateFactory(),
			SomeAggregate::class
		);

		$repository->save($aggregate = new SomeAggregate($id = Uuid::uuid4()));
		$loadedAggregate = $repository->load((string)$id);

		self::assertEquals((string)$aggregate->id(), (string)$loadedAggregate->id());
	}
}

final class SomeAggregate implements Aggregate
{
	private $id;

	private $uncommittedEvents;

	private $version;

	public function __construct(Uuid $id = null)
	{
		printf('__construct("%s")' . PHP_EOL, (string)$id);
		$this->id = $id ?? Uuid::uuid4();
		$this->uncommittedEvents = [];
		$this->version = 0;
	}

	public function id(): UuidInterface
	{
		return $this->id;
	}

	public function apply(Aggregate\DomainEventMessage $eventMessage): Aggregate
	{
		$handler = $this->determineEventHandlerMethodFor($eventMessage);

		if (!method_exists($this, $handler)) {
			throw new \RuntimeException(sprintf(
				'Missing event handler method %s for aggregate root %s',
				$handler,
				get_class($this)
			));
		}

		$this->{$handler}($eventMessage);
	}

	/**
	 * @param Aggregate\DomainEventMessage $e
	 *
	 * @return string
	 */
	private function determineEventHandlerMethodFor(Aggregate\DomainEventMessage $e): string
	{
		return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
	}

	public function uncommittedEvents(): EventStream
	{
		return new InMemoryEventStream($this->uncommittedEvents);
	}

	public function reconstituteFromHistory(EventStream $events): Aggregate
	{
		$self = new self();

		/** @var Aggregate\DomainEventMessage $event */
		foreach ($events as $event) {
			$self->apply($event);
		}

		return $self;
	}

	public function initialize(EventStream $events): Aggregate
	{
		foreach ($events as $event) {
			$this->version++;
			$this->apply($event);
		}

		return $this;
	}

	public function version(): int
	{
		return $this->version;
	}
}
