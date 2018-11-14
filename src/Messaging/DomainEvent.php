<?php declare(strict_types=1);

namespace Mercur\Messaging;

use Mercur\Common\DateTime;
use Mercur\EventSourcing\EventMessage;
use Mercur\Messaging\Message\Metadata;
use Mercur\Messaging\Message\Payload;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class DomainMessage
 *
 * @package Micrum\Domain
 */
class DomainEvent implements EventMessage
{
	/**
	 * @var Uuid
	 */
	protected $id;

	/**
	 * @var DateTime
	 */
	protected $time;

	/**
	 * @var Metadata
	 */
	protected $metadata;

	/**
	 * @var Payload
	 */
	protected $payload;

	/**
	 * @var string
	 */
	protected $messageName;

	/**
	 * DomainMessage constructor.
	 *
	 * @param UuidInterface $id
	 * @param DateTime      $occurredAt
	 * @param Metadata      $metadata
	 * @param Payload       $payload
	 *
	 * @throws \Exception
	 */
	private function __construct(
		UuidInterface $id,
		DateTime $occurredAt,
		Metadata $metadata,
		Payload $payload
	) {
		$this->id = $id;
		$this->time = $occurredAt;
		$this->metadata = $metadata;
		$this->payload = $payload;
		$this->messageName = get_called_class();
	}

	public function id(): UuidInterface
	{
		return $this->id;
	}

	public function time(): DateTime
	{
		return $this->time;
	}

	public function metadata(): Metadata
	{
		return $this->metadata;
	}

	public function payload(): Payload
	{
		return $this->payload;
	}

	public function addMetadata(Metadata $metadata): Message
	{
		$clone = clone $this;
		$clone->metadata = $metadata->merge($this->metadata);

		return $clone;
	}

	/**
	 * Returns a new domain message that occurred now.
	 *
	 * @param array $payload
	 * @param array $metadata
	 *
	 * @return DomainEvent
	 * @throws \Exception
	 */
	public static function occur(array $payload, array $metadata = []): self
	{
		return new static(Uuid::uuid4(), new DateTime('now'), new Metadata($metadata), Payload::fromArray($payload));
	}

	public function jsonSerialize()
	{
		return [
			'_metadata' => $this->metadata,
			'message' => $this->messageName,
			'data' => [
				'id' => $this->id->toString(),
				'time' => $this->time->toString(),
				'payload' => $this->payload,
			]
		];
	}
}
