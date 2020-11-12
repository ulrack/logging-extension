<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\LoggingExtension\Tests\Component\Plugin;

use stdClass;
use Exception;
use PHPUnit\Framework\TestCase;
use PhpUnified\Log\Common\LoggerInterface;
use GrizzIt\Storage\Component\ObjectStorage;
use Ulrack\LoggingExtension\Component\Plugin\LoggerPlugin;

/**
 * @coversDefaultClass \Ulrack\LoggingExtension\Component\Plugin\LoggerPlugin
 */
class LoggerPluginTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::before
     *
     * @return void
     */
    public function testBefore(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $subject = new LoggerPlugin(
            $logger,
            LoggerInterface::INFO
        );

        $logger->expects(static::once())
            ->method('log')
            ->with(
                LoggerInterface::INFO,
                'Method testMethod on stdClass called.',
                ['parameters' => ['foo' => 'bar', 'baz' => 'qux']]
            );

        $subject->before(
            new ObjectStorage(['foo' => 'bar', 'baz' => 'qux']),
            'testMethod',
            new stdClass()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::after
     *
     * @return void
     */
    public function testAfter(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $subject = new LoggerPlugin(
            $logger,
            LoggerInterface::INFO
        );

        $logger->expects(static::once())
            ->method('log')
            ->with(
                LoggerInterface::INFO,
                'Method testMethod on stdClass called.',
                [
                    'parameters' => ['foo' => 'bar', 'baz' => 'qux'],
                    'return' => 'return'
                ]
            );

        $subject->after(
            new ObjectStorage(['foo' => 'bar', 'baz' => 'qux']),
            'testMethod',
            new stdClass(),
            'return'
        );
    }

    /**
     * @covers ::__construct
     * @covers ::around
     *
     * @return void
     */
    public function testAround(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $exception = new Exception();
        $subject = new LoggerPlugin(
            $logger,
            LoggerInterface::INFO
        );

        $logger->expects(static::once())
            ->method('log')
            ->with(
                LoggerInterface::INFO,
                'Method testMethod on stdClass called, but failed.',
                [
                    'parameters' => ['foo' => 'bar', 'baz' => 'qux'],
                    'exception' => $exception
                ]
            );

        $this->expectException(Exception::class);

        $subject->around(
            new ObjectStorage(['foo' => 'bar', 'baz' => 'qux']),
            'testMethod',
            new stdClass(),
            (function () use ($exception) {
                throw $exception;
            })
        );
    }
}
