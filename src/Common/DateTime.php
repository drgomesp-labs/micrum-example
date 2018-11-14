<?php declare(strict_types=1);

namespace Mercur\Common;

/**
 * Class DateTime
 *
 * @package Mercur\Common
 */
class DateTime extends \DateTimeImmutable
{
	/**
	 * @return string
	 */
	public function toString(): string
	{
		return $this->format('U');
	}
}
