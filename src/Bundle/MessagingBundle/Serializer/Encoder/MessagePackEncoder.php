<?php declare(strict_types=1);

namespace Mercur\Bundle\MessagingBundle\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Class MessagePackEncoder
 *
 * @package Mercur\Serializer\Encoder
 */
class MessagePackEncoder implements EncoderInterface
{
	public function encode($data, $format, array $context = [])
	{
		// TODO: Implement encode() method.
	}

	public function supportsEncoding($format)
	{
		// TODO: Implement supportsEncoding() method.
	}
}
