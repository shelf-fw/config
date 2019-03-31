<?php

namespace Shelf\Config;

interface ConfigInterface
{
    // Application config folder name.
    const CONFG_FOLDER_NAME = 'etc';
    // Modules Settings
    const CONFIG_MODULES_PATTERN = BP . '/app/code/*/*/' . self::CONFG_FOLDER_NAME . '/*.*';
    // Global Settings
    const CONFIG_GLOBAL_PATTERN = BP . '/app/' . self::CONFG_FOLDER_NAME . '/*.*';
    // Composer Settings
    const CONFIG_COMPOSER_MODULE_INSTALLED_PATTERN = '/' . self::CONFG_FOLDER_NAME . '/*.*';
    // Config folder for cache.
    const CONFIG_CACHE_FILE = BP . '/var/cache/all-config.php';
    const CONFIG_CACHE_KEY = 'config_cache';

    /**
     * Get Application Settings
     * @return \Zend\Config\Config|array
     */
    public static function getConfig();
}