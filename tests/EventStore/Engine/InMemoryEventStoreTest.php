<?php declare(strict_types=1);

namespace Mercur\Tests\EventStore\Engine;

use Mercur\EventStore\Engine\InMemoryEventStoreEngine;
use Mercur\Messaging\DomainEvent;
use PHPUnit\Framework\TestCase;

class InMemoryEventStoreTest extends TestCase
{
	/**
	 * @test
	 *
	 * @throws \Exception
	 */
	public function it_can_append_events()
	{
		$msg1 = DomainEvent::occur(['foo' => 'bar']);
		$msg2 = DomainEvent::occur(['bar' => 'foo']);

		$engine = new InMemoryEventStoreEngine();
		$engine->append($msg1, $msg2);

		$events = $engine->read();

		self::assertContains($msg1, $events);
		self::assertContains($msg2, $events);
		self::assertCount(2, $events);
	}

	/**
	 * @test
	 *
	 * @throws \Exception
	 */
	public function it_can_read_events()
	{
		$engine = new InMemoryEventStoreEngine();
		$events = $engine->read();

		self::assertIsArray((array)$events);
		self::assertCount(0, $events);

		$engine->append(DomainEvent::occur([]));

		$events = $engine->read();
		self::assertCount(1, $events);
	}
}
