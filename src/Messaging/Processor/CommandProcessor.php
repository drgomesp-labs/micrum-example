<?php declare(strict_types=1);

namespace Mercur\Messaging\Processor;

use Interop\Queue\Message;
use Mercur\Messaging\Factory\CommandFactory;
use Mercur\Messaging\Processor;
use Mercur\Messaging\Processor\Exception\ProcessingException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class EventProcessor
 *
 * @package Mercur\Messaging\Processor
 */
final class CommandProcessor implements Processor
{
	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @var MessageBusInterface
	 */
	private $messageBus;

	/**
	 * @var CommandFactory
	 */
	private $commandFactory;

	/**
	 * CommandProcessor constructor.
	 *
	 * @param LoggerInterface     $logger
	 * @param MessageBusInterface $messageBus
	 * @param CommandFactory      $commandFactory
	 */
	public function __construct(
		LoggerInterface $logger,
		MessageBusInterface $messageBus,
		CommandFactory $commandFactory
	) {
		$this->logger = $logger;
		$this->messageBus = $messageBus;
		$this->commandFactory = $commandFactory;
	}

	public function process(Message $msg): void
	{
		try {
			$body = json_decode($msg->getBody(), true);
			$payload = $body['data'] + ['headers' => $msg->getHeaders()];

			$command = $this->commandFactory->create($body['message'], $payload);

			$this->logger->debug(sprintf('Processing command', ['command' => $command]));

			$this->messageBus->dispatch($command);
		} catch (\Throwable $e) {
			throw new ProcessingException('Failed to process command', $e->getCode(), $e);
		}
	}
}
