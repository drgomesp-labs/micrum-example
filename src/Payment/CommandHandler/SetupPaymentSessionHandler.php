<?php declare(strict_types=1);

namespace Mercur\Payment\CommandHandler;

use Mercur\Payment\Command\SetupPaymentSession;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class SetupPaymentSessionHandler
 *
 * @package Mercur\Payment\CommandHandler
 */
class SetupPaymentSessionHandler implements MessageHandlerInterface
{
	/**
	 * @param SetupPaymentSession $command
	 */
	public function __invoke(SetupPaymentSession $command): void
	{
		var_export($command);
	}
}
