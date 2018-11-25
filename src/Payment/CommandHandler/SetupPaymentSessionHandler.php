<?php declare(strict_types=1);

namespace Mercur\Payment\CommandHandler;

use Mercur\EventSourcing\Aggregate\AggregateRepository;
use Mercur\Payment\Command\SetupPaymentSession;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class SetupPaymentSessionHandler
 *
 * @package Mercur\Payment\CommandHandler
 */
final class SetupPaymentSessionHandler implements MessageHandlerInterface
{
	/**
	 * @var \Mercur\EventSourcing\Aggregate\AggregateRepository
	 */
	private $repository;

	/**
	 * SetupPaymentSessionHandler constructor.
	 *
	 * @param \Mercur\EventSourcing\Aggregate\AggregateRepository $repository
	 */
	public function __construct(AggregateRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @param \Mercur\Payment\Command\SetupPaymentSession $command
	 */
	public function __invoke(SetupPaymentSession $command): void
	{
		var_export($this->repository->load($command->payload()['shopId']));
	}
}
