<?php declare(strict_types=1);

namespace Mercur\Bundle\MessagingBundle\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface;

/**
 * Class MessagePackDecoder
 *
 * @package Mercur\Serializer\Encoder
 */
class MessagePackDecoder implements DecoderInterface
{
	public function decode($data, $format, array $context = [])
	{
		// TODO: Implement decode() method.
	}

	public function supportsDecoding($format)
	{
		// TODO: Implement supportsDecoding() method.
	}
}
