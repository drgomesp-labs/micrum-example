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
	use MessageTrait;

	/**
	 * @var Uuid
	 */
	protected $id;

	/**
	 * @var DateTime
	 */
	protected $time;

	public function id(): UuidInterface
	{
		return $this->id;
	}

	public function time(): DateTime
	{
		return $this->time;
	}

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
		$this->time = $occurredAt;
		$this->id = $id;
		$this->metadata = $metadata;
		$this->payload = $payload;
		$this->messageName = get_called_class();
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
