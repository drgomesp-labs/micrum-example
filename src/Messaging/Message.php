<?php declare(strict_types=1);

namespace Mercur\Messaging;

use Mercur\Messaging\Message\Metadata;
use Mercur\Messaging\Message\Payload;

/**
 * Defines the most basic interface of a message.
 *
 * @package Mercur\Messaging
 */
interface Message extends \JsonSerializable
{
	/**
	 * Returns the message metadata.
	 *
	 * @return Metadata
	 */
	public function metadata(): Metadata;

	/**
	 * Returns the message payload.
	 *
	 * @return Payload
	 */
	public function payload(): Payload;
}
