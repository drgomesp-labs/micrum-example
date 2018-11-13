<?php declare(strict_types=1);

namespace Mercur\Messaging;

use Interop\Queue\ConnectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Consumer
 *
 * @package Mercur\Messaging
 */
final class Consumer
{
	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @var Consumer
	 */
	private $consumer;

	/**
	 * EntryPoint constructor.
	 *
	 * @param LoggerInterface   $logger
	 * @param ConnectionFactory $connectionFactory
	 * @param string            $topicName
	 */
	public function __construct(LoggerInterface $logger, ConnectionFactory $connectionFactory, string $topicName)
	{
		$context = $connectionFactory->createContext();

		$this->logger = $logger;
		$this->consumer = $context->createConsumer($context->createTopic($topicName));
	}

	public function consume(callable $callback): void
	{
		$message = $this->consumer->receive(25);

		if ($message === null) {
			return;
		}

		try {
			$this->logger->debug('Message consumed', ['msg' => $message->getBody()]);

			$callback($message);

			$this->consumer->acknowledge($message);
		} catch (\Throwable $e) {
			$this->logger->error($e->getMessage(), ['e' => $e]);
		}
	}
}
