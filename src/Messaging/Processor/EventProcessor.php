<?php declare(strict_types=1);

namespace Mercur\Messaging\Processor;

use Enqueue\Client\TopicSubscriberInterface;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;
use Mercur\Messaging\Factory\EventFactory;
use Mercur\Messaging\Factory\Exception\UnknownEventException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class EventProcessor
 *
 * @package Mercur\Messaging\Processor
 */
final class EventProcessor implements Processor, TopicSubscriberInterface
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
	 * EventProcessor constructor.
	 *
	 * @param LoggerInterface     $logger
	 * @param EventFactory        $eventFactory
	 * @param MessageBusInterface $bus
	 */
	public function __construct(
		LoggerInterface $logger,
		EventFactory $eventFactory,
		MessageBusInterface $bus
	) {
		$this->logger = $logger;
		$this->eventFactory = $eventFactory;
		$this->bus = $bus;
	}

	public function process(Message $message, Context $context)
	{
		try {
			$body = json_decode($message->getBody(), true);
			$event = $this->eventFactory->create($body['message'], $body['data'], $message->getHeaders());
			$this->bus->dispatch(new Envelope($event));
		} catch (UnknownEventException $e) {
			$this->logger->notice($e->getMessage(), [
				'class' => \get_class($message),
				'message' => $message,
			]);
		} catch (\Throwable $e) {
			$this->logger->error('Failed to process event', [
				'message' => $message,
				'error' => $e->getMessage(),
				'stacktrace' => $e->getTraceAsString(),
			]);

			return self::ACK;
		}

		return self::ACK;
	}

	public static function getSubscribedTopics()
	{
		return 'adyen_events';
	}
}
