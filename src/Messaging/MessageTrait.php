<?php declare(strict_types=1);

namespace Mercur\Messaging;

use Mercur\Messaging\Message\Metadata;
use Mercur\Messaging\Message\Payload;

/**
 * Trait MessageTrait
 *
 * @package Mercur\Messaging
 */
trait MessageTrait
{
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
	 * @return Metadata
	 */
	public function metadata(): Metadata
	{
		return $this->metadata;
	}

	/**
	 * @return Payload
	 */
	public function payload(): Payload
	{
		return $this->payload;
	}

	/**
	 * @param Metadata $metadata
	 *
	 * @return self
	 */
	public function addMetadata(Metadata $metadata): self
	{
		$clone = clone $this;
		$clone->metadata = $metadata->merge($this->metadata);

		return $clone;
	}
}
