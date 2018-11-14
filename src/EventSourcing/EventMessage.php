<?php declare(strict_types=1);

namespace Mercur\EventSourcing;

use Mercur\Common\DateTime;
use Mercur\Messaging\Message;

/**
 * Defines an event message, which is essentially a timestamped message.
 *
 * @package Mercur\EventSourcing
 */
interface EventMessage extends Message
{
	/**
	 * @return DateTime
	 */
	public function time(): DateTime;
}
