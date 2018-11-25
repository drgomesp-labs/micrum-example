<?php declare(strict_types=1);

namespace Mercur\EventSourcing\Aggregate;

use Mercur\EventSourcing\EventMessage;
use Mercur\Messaging\DomainEvent;

/**
 * Class DomainEventMessage
 *
 * @package Mercur\EventSourcing\Aggregate
 */
final class DomainEventMessage extends DomainEvent implements EventMessage
{
	
	
	public function version(): int
	{
		// TODO: Implement version() method.
	}
}
