<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\LoggingExtension\Component\Plugin;

use Throwable;
use PhpUnified\Log\Common\LoggerInterface;
use GrizzIt\Storage\Common\StorageInterface;
use Ulrack\AopExtension\Common\PluginInterface;

class LoggerPlugin implements PluginInterface
{
    /**
     * Contains the logger.
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Contains the log level used when logging.
     *
     * @var string
     */
    private $logLevel;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     * @param string $logLevel
     */
    public function __construct(
        LoggerInterface $logger,
        string $logLevel
    ) {
        $this->logger = $logger;
        $this->logLevel = $logLevel;
    }

    /**
     * Invoked before the method invocation.
     *
     * @param StorageInterface $parameters
     * @param string $methodName
     * @param mixed $subject
     *
     * @return void
     */
    public function before(
        StorageInterface $parameters,
        string $methodName,
        $subject
    ): void {
        $this->logger->log(
            $this->logLevel,
            sprintf(
                'Method %s on %s called.',
                $methodName,
                get_class($subject)
            ),
            ['parameters' => iterator_to_array($parameters)]
        );
    }

    /**
     * Invoked after the method invocation.
     *
     * @param StorageInterface $parameters
     * @param string $methodName
     * @param mixed $subject
     * @param mixed $return
     *
     * @return mixed
     */
    public function after(
        StorageInterface $parameters,
        string $methodName,
        $subject,
        $return
    ) {
        $this->logger->log(
            $this->logLevel,
            sprintf(
                'Method %s on %s called.',
                $methodName,
                get_class($subject)
            ),
            [
                'parameters' => iterator_to_array($parameters),
                'return' => $return
            ]
        );

        return $return;
    }

    /**
     * Invoked around the method invocation.
     *
     * @param StorageInterface $parameters
     * @param string $methodName
     * @param mixed $subject
     * @param callable $proceed
     *
     * @return mixed
     */
    public function around(
        StorageInterface $parameters,
        string $methodName,
        $subject,
        callable $proceed
    ) {
        try {
            return $proceed();
        } catch (Throwable $exception) {
            $this->logger->log(
                $this->logLevel,
                sprintf(
                    'Method %s on %s called, but failed.',
                    $methodName,
                    get_class($subject)
                ),
                [
                    'parameters' => iterator_to_array($parameters),
                    'exception' => $exception
                ]
            );

            throw $exception;
        }
    }
}
