<?php

namespace Shelf\Config;

interface ConfigInterface
{
    // Modules Settings
    const CONFIG_MODULES_PATTERN = BP . '/app/code/*/*/etc/*.*';
    // Global Settings
    const CONFIG_GLOBAL_PATTERN = BP . '/app/etc/*.*';
    // Composer Settings
    const CONFIG_COMPOSER_MODULE_INSTALLED_PATTERN = '/etc/*.*';

    /**
     * Get Application Settings
     * @return \Zend\Config\Config
     */
    public static function getConfig();
}