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
	 * @param \Mercur\Messaging\Message\Payload $payload
	 */
	public function __construct(Payload $payload)
	{
		$this->metadata = new Metadata();
		$this->payload = $payload;
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
