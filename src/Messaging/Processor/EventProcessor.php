<?php declare(strict_types=1);

namespace Mercur\Messaging\Processor;

use Enqueue\MessengerAdapter\EnvelopeItem\TransportConfiguration;
use Interop\Queue\Message;
use Mercur\Messaging\Factory\EventFactory;
use Mercur\Messaging\Processor;
use Mercur\Messaging\Processor\Exception\ProcessingException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class EventProcessor
 *
 * @package Mercur\Messaging\Processor
 */
final class EventProcessor implements Processor
{
	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @var EventFactory
	 */
	private $eventFactory;

	/**
	 * @var MessageBusInterface
	 */
	private $bus;

	/**
	 * @var string
	 */
	private $eventTopicName;

	/**
	 * EventProcessor constructor.
	 *
	 * @param LoggerInterface     $logger
	 * @param EventFactory        $eventFactory
	 * @param MessageBusInterface $bus
	 * @param string              $eventTopicName
	 */
	public function __construct(
		LoggerInterface $logger,
		EventFactory $eventFactory,
		MessageBusInterface $bus,
		string $eventTopicName
	) {
		$this->logger = $logger;
		$this->eventFactory = $eventFactory;
		$this->bus = $bus;
		$this->eventTopicName = $eventTopicName;
	}

	public function process(Message $msg): void
	{
		try {
			$body = json_decode($msg->getBody(), true);
			$payload = $body['data'] + ['headers' => $msg->getHeaders()];

			$event = $this->eventFactory->create($body['message'], $payload);

			$this->logger->debug(sprintf('Processing event', ['event' => $event]));

			$this->bus->dispatch((new Envelope($event))->with(new TransportConfiguration([
				'topic' => $this->eventTopicName,
			])));
		} catch (\Throwable $e) {
			throw new ProcessingException(sprintf('Failed to process event (%s)', $e->getMessage()), $e->getCode(), $e);
		}
	}
}
