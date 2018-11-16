<?php declare(strict_types=1);

namespace Mercur\Messaging\Factory;

use Mercur\Messaging\Message;

/**
 * Interface MessageFactory
 *
 * @package Mercur\Messaging\Factory
 */
interface MessageFactory
{
	/**
	 * Creates an event of the type defined in as the message name, given a payload and some headers.
	 *
	 * @param string $messageName
	 * @param array  $payload
	 * @param array  $headers
	 *
	 * @return Message
	 */
	public function create(string $messageName, array $payload, array $headers = []): Message;
}
