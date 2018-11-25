<?php declare(strict_types=1);

namespace Mercur\Messaging;

use Mercur\Messaging\Message\Metadata;
use Mercur\Messaging\Message\Payload;

/**
 * Class Command
 *
 * @package Mercur\Messaging
 */
abstract class Command implements CommandMessage
{
	use MessageTrait;

	/**
	 * Command constructor.
	 *
	 * @param \Mercur\Messaging\Message\Payload       $payload
	 * @param \Mercur\Messaging\Message\Metadata|null $metadata
	 */
	public function __construct(Payload $payload, Metadata $metadata = null)
	{
		$this->payload = $payload;
		$this->metadata = $metadata ?? new Metadata();
		$this->messageName = get_called_class();
	}

	public function commandName(): string
	{
		return $this->messageName;
	}

	public function jsonSerialize()
	{
		return [
			'_metadata' => $this->metadata,
			'message' => $this->messageName,
			'data' => [
				'payload' => $this->payload,
			]
		];
	}
}
