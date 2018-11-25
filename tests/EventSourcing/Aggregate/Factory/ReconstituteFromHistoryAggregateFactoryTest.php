<?php declare(strict_types=1);

namespace Mercur\Tests\EventSourcing\Aggregate\Factory;

use Mercur\EventSourcing\Aggregate;
use Mercur\EventSourcing\Aggregate\DomainEventMessage;
use Mercur\EventSourcing\Aggregate\Factory\Exception\InvalidAggregateTypeException;
use Mercur\EventSourcing\Aggregate\Factory\ReconstituteFromHistoryAggregateFactory;
use Mercur\EventSourcing\EventStream;
use Mercur\EventSourcing\EventStream\InMemoryEventStream;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ReconstituteFromHistoryAggregateFactoryTest
 *
 * @package Mercur\Tests\EventSourcing\Aggregate\Factory
 */
class ReconstituteFromHistoryAggregateFactoryTest extends TestCase
{
	/**
	 * @test
	 */
	public function it_can_create_aggregate_from_event_stream()
	{
		$factory = new ReconstituteFromHistoryAggregateFactory();
		$aggregate = $factory->create(StubAggregate::class, new InMemoryEventStream([]));

		self::assertInstanceOf(StubAggregate::class, $aggregate);
	}

	/**
	 * @test
	 */
	public function it_throws_exception_when_aggregate__type_is_invalid()
	{
		self::expectException(InvalidAggregateTypeException::class);

		$factory = new ReconstituteFromHistoryAggregateFactory();
		$factory->create(\stdClass::class, new InMemoryEventStream([]));
	}
}

final class StubAggregate implements Aggregate
{
	/**
	 * @var UuidInterface
	 */
	private $id;

	private $version;

	private $uncommittedEvents;

	public function __construct()
	{
		$this->id = Uuid::uuid4();
		$this->uncommittedEvents = [];
		$this->version = 0;
	}

	public function id(): UuidInterface
	{
		return $this->id;
	}

	public function apply(DomainEventMessage $eventMessage): Aggregate
	{
		$handler = $this->determineEventHandlerMethodFor($eventMessage);

		if (!method_exists($this, $handler)) {
			throw new \RuntimeException(sprintf(
				'Missing event handler method %s for aggregate root %s',
				$handler,
				get_class($this)
			));
		}

		return $this->{$handler}($eventMessage);
	}

	/**
	 * @param DomainEventMessage $e
	 *
	 * @return string
	 */
	private function determineEventHandlerMethodFor(DomainEventMessage $e): string
	{
		return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
	}

	public function uncommittedEvents(): EventStream
	{
		return new InMemoryEventStream($this->uncommittedEvents);
	}

	public function reconstituteFromHistory(EventStream $events): Aggregate
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

