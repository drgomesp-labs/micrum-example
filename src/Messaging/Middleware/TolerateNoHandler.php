<?php declare(strict_types=1);

namespace Mercur\Messaging\Middleware;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

/**
 * Class TolerateNoHandler
 *
 * @package Mercur\Messaging\Middleware
 */
class TolerateNoHandler implements MiddlewareInterface
{
	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * TolerateNoHandler constructor.
	 *
	 * @param LoggerInterface $logger
	 */
	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	public function handle(Envelope $envelope, StackInterface $stack): Envelope
	{
		try {
			return $stack->next()->handle($envelope, $stack);
		} catch (NoHandlerForMessageException $e) {
			$this->logger->notice(get_class($envelope->getMessage()));
			return $stack->next()->handle($envelope, $stack);
		}
	}
}
