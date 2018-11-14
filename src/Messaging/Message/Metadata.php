<?php declare(strict_types=1);

namespace Mercur\Messaging\Message;

/**
 * Class Metadata
 *
 * @package Micrum\Messaging
 */
class Metadata extends \ArrayObject implements \JsonSerializable
{
	public function jsonSerialize()
	{
		return (array)$this;
	}

	/**
	 * Merges this metadata with a given metadata. With the default behaviour, the merge operation will ignore repeated
	 * keys and keep the original values – you can override this behaviour by setting the $override flag to true.
	 *
	 * @param Metadata $metadata
	 * @param bool     $override
	 *
	 * @return Metadata
	 */
	public function merge(Metadata $metadata, bool $override = false): Metadata
	{
		if ($override) {
			$clone = new self(array_merge((array)$this, (array)$metadata));

			return $clone;
		}

		$clone = new self((array)$this + (array)$metadata);

		return $clone;
	}
}
