<?php declare(strict_types=1);

namespace Mercur\Payment;

use Interop\Queue\Message;
use Mercur\Messaging\Consumer;
use Mercur\Messaging\Processor;
use Mercur\Messaging\Processor\Exception\ProcessingException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EntryPoint
 *
 * @package Mercur
 */
final class EntryPoint extends Command
{
	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @var Consumer
	 */
	private $commandConsumer;

	/**
	 * @var Consumer
	 */
	private $eventConsumer;

	/**
	 * @var Processor
	 */
	private $commandProcessor;

	/**
	 * @var Processor
	 */
	private $eventProcessor;

	/**
	 * EntryPoint constructor.
	 *
	 * @param LoggerInterface $logger
	 * @param Consumer        $commandConsumer
	 * @param Consumer        $eventConsumer
	 * @param Processor       $commandProcessor
	 * @param Processor       $eventProcessor
	 */
	public function __construct(
		LoggerInterface $logger,
		Consumer $commandConsumer,
		Consumer $eventConsumer,
		Processor $commandProcessor,
		Processor $eventProcessor
	) {
		parent::__construct();

		$this->logger = $logger;
		$this->commandConsumer = $commandConsumer;
		$this->eventConsumer = $eventConsumer;
		$this->commandProcessor = $commandProcessor;
		$this->eventProcessor = $eventProcessor;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		while (true) {
			$this->commandConsumer->consume(function (Message $msg) {
				try {
					$this->commandProcessor->process($msg);
				} catch (ProcessingException $e) {
					$this->logger->error($e->getMessage(), ['e' => $e]);
				}
			});

			$this->eventConsumer->consume(function (Message $msg) {
				try {
					$this->eventProcessor->process($msg);
				} catch (ProcessingException $e) {
					$this->logger->error($e->getMessage(), ['stacktrace' => $e->getTraceAsString()]);
				}
			});
		}
	}
}
