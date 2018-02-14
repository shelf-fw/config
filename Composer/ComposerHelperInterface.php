<?php

namespace Shelf\Config\Composer;

/**
 * Interface ComposerHelperInterface
 * @package Shelf\Config\Composer
 */
interface ComposerHelperInterface
{
    const JSON_INSTALLED_FILE = __DIR__ . '/../../../../../vendor/composer/installed.json';
    const SHELF_MODULE_TYPE = 'shelf_module';
    const VENDOR_PATH = __DIR__ . '/../../../../../vendor';

    /**
     * Get all Shelf Modules Installed via Composer
     * @return array
     */
    public function getInstalledModules();

    /**
     * Get all Composer Installed Packages
     * @return array
     */
    public function getAllComposerInstalledPackages();
}