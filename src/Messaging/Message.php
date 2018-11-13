<?php declare(strict_types=1);

namespace Mercur\Messaging;

use Micrum\Messaging\Message\Metadata;
use Micrum\Messaging\Message\Payload;
use Ramsey\Uuid\UuidInterface;

/**
 * Defines the most basic interface of a message.
 *
 * @package Mercur\Messaging
 */
interface Message extends \JsonSerializable
{
	/**
	 * Returns the message unique identifier.
	 *
	 * @return UuidInterface
	 */
	public function id(): UuidInterface;

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

	/**
	 * Returns a copy of this message, with the added metadata.
	 *
	 * @param Metadata $metadata
	 *
	 * @return Message
	 */
	public function addMetadata(Metadata $metadata): Message;
}
