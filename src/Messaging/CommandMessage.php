<?php declare(strict_types=1);

namespace Mercur\Messaging;

/**
 * Interface CommandMessage
 *
 * @package Mercur\Messaging
 */
interface CommandMessage extends Message
{
	/**
	 * Returns the command name.
	 *
	 * @return string
	 */
	public function commandName(): string;
}
