<?php declare(strict_types=1);

namespace Mercur\Messaging\Message;

/**
 * Defines an abstraction for a message payload.
 *
 * @package Mercur\Messaging\Message
 */
class Payload extends \ArrayObject implements \JsonSerializable
{
	/**
	 * @param string $json
	 *
	 * @return Payload
	 */
	public static function fromJson(string $json): self
	{
		return new self(json_decode($json, true));
	}

	/**
	 * @param array $arr
	 *
	 * @return Payload
	 */
	public static function fromArray(array $arr): self
	{
		return new self($arr);
	}

	public function jsonSerialize()
	{
		return (array)$this;
	}
}
