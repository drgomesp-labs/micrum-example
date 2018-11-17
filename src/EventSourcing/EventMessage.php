<?php declare(strict_types=1);

namespace Mercur\EventSourcing;

use Mercur\Common\DateTime;
use Mercur\Messaging\Message;
use Ramsey\Uuid\UuidInterface;

/**
 * Defines an event message, which is essentially a timestamped message.
 *
 * @package Mercur\EventSourcing
 */
interface EventMessage extends Message
{
	/**
	 * Returns the message unique identifier.
	 *
	 * @return UuidInterface
	 */
	public function id(): UuidInterface;

	/**
	 * Returns the time when the message occurred.
	 *
	 * @return DateTime
	 */
	public function time(): DateTime;
}
