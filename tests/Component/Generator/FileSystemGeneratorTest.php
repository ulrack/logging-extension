<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\LoggingExtension\Tests\Component\Generator;

use PHPUnit\Framework\TestCase;
use GrizzIt\Vfs\Common\FileSystemInterface;
use GrizzIt\Vfs\Common\FileSystemDriverInterface;
use Ulrack\Kernel\Common\Manager\ResourceManagerInterface;
use Ulrack\LoggingExtension\Component\Generator\FileSystemGenerator;

/**
 * @coversDefaultClass \Ulrack\LoggingExtension\Component\Generator\FileSystemGenerator
 */
class FileSystemGeneratorTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getLogFileSystem
     *
     * @return void
     */
    public function testGetLogFileSystem(): void
    {
        $resourceManager = $this->createMock(ResourceManagerInterface::class);
        $rootFileSystem = $this->createMock(FileSystemInterface::class);
        $fileSystemDriver = $this->createMock(FileSystemDriverInterface::class);
        $resourceManager->expects(static::once())
            ->method('getRootFileSystem')
            ->willReturn($rootFileSystem);

        $rootFileSystem->expects(static::once())
            ->method('isDirectory')
            ->with('var/log')
            ->willReturn(false);

        $rootFileSystem->expects(static::once())
            ->method('makeDirectory')
            ->with('var/log');

        $resourceManager->expects(static::once())
            ->method('getFileSystemDriver')
            ->willReturn($fileSystemDriver);

        $rootFileSystem->expects(static::once())
            ->method('realpath')
            ->with('var/log')
            ->willReturn('/var/log');

        $fileSystemDriver->expects(static::once())
            ->method('connect')
            ->with('/var/log')
            ->willReturn($this->createMock(FileSystemInterface::class));

        $subject = new FileSystemGenerator($resourceManager);
        $result = $subject->getLogFileSystem('var/log');
        $this->assertInstanceOf(
            FileSystemInterface::class,
            $result
        );

        $this->assertSame($result, $subject->getLogFileSystem('var/log'));
    }
}
