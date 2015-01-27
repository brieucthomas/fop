<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;

/**
 * Logs console exceptions.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConsoleExceptionListener
{
    /**
     * A logger object.
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructs.
     *
     * @param LoggerInterface $logger A logger instance
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Logs console exception.
     *
     * @param ConsoleExceptionEvent $event
     */
    public function onConsoleException(ConsoleExceptionEvent $event)
    {
        $command = $event->getCommand();
        $exception = $event->getException();

        $message = sprintf(
            '%s: %s (uncaught exception) at %s line %s while running console command `%s`',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $command->getName()
        );

        $this->logger->error($message);
    }
}
