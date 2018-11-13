<?php declare(strict_types=1);

namespace Mercur\Messaging;

use Interop\Queue\Message;
use Mercur\Messaging\Processor\Exception\ProcessingException;

/**
 * Interface Processor
 *
 * @package Mercur\Messaging
 */
interface Processor
{
	/**
	 * Processes a given message as a domain interaction (commands, queries, events).
	 *
	 * @param Message $message
	 *
	 * @throws ProcessingException
	 */
	public function process(Message $message): void;
}
