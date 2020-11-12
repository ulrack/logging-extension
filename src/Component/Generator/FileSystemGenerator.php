<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\LoggingExtension\Component\Generator;

use GrizzIt\Vfs\Common\FileSystemInterface;
use Ulrack\Kernel\Common\Manager\ResourceManagerInterface;

class FileSystemGenerator
{
    /**
     * Contains the root file system.
     *
     * @var ResourceManagerInterface
     */
    private $resourceManager;

    /**
     * Contains the open log directories.
     *
     * @var FileSystemInterface[]
     */
    private $logDirectories = [];

    /**
     * Constructor.
     *
     * @param ResourceManagerInterface $resourceManager
     */
    public function __construct(ResourceManagerInterface $resourceManager)
    {
        $this->resourceManager = $resourceManager;
    }

    /**
     * Creates a file system for logging and returns it.
     *
     * @param string $directory
     *
     * @return FileSystemInterface
     */
    public function getLogFileSystem(string $directory): FileSystemInterface
    {
        if (!isset($this->logDirectories[$directory])) {
            $rootFileSystem = $this->resourceManager->getRootFileSystem();
            if (!$rootFileSystem->isDirectory($directory)) {
                $rootFileSystem->makeDirectory($directory);
            }

            $this->logDirectories[$directory] = $this->resourceManager
                ->getFileSystemDriver()
                ->connect(
                    $rootFileSystem->realpath($directory)
                );
        }

        return $this->logDirectories[$directory];
    }
}
