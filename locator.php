<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

use Ulrack\LoggingExtension\Common\UlrackLoggingExtensionPackage;
use GrizzIt\Configuration\Component\Configuration\PackageLocator;

PackageLocator::registerLocation(
    __DIR__,
    UlrackLoggingExtensionPackage::PACKAGE_NAME
);
