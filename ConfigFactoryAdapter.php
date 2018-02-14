<?php

namespace Shelf\Config;

use Shelf\Config\Composer\ComposerHelper;
use Zend\Config\Config as ZendConfig;
use Zend\Config\Factory;

/**
 * Class ConfigFactoryAdapter
 * @package Shelf\Config
 */
class ConfigFactoryAdapter extends Factory implements ConfigInterface
{
    /**
     * @var ComposerHelper
     */
    public static $_composerHelper;

    /**
     * @var ZendConfig
     */
    protected static $_config;

    /**
     * Get Application Settings
     * Order:
     *  - DB Rewrite all
     *  - Global Rewrite Modules
     *  - Local Modules
     *  - Composer Modules
     * @return \Zend\Config\Config
     */
    public static function getConfig()
    {
        if (! self::$_config) {
            $composerModuleConfig = self::_loadComposerModulesConfig();
            $localModulesConfig = self::_loadLocalModulesConfig();
            $globalConfig = self::_loadGlobalConfig();
            //@todo implement DB config | Override this via Service Manager in other module

            if ($composerModuleConfig instanceof ZendConfig && $localModulesConfig instanceof ZendConfig) {
                $config = $composerModuleConfig->merge($localModulesConfig);
            } elseif ($localModulesConfig instanceof ZendConfig) {
                $config = $localModulesConfig;
            }

            if ($config instanceof ZendConfig) {
                $config->merge($globalConfig);
            } else {
                $config = $globalConfig;
            }

            self::$_config = $config;
        }

        return self::$_config;
    }

    /**
     * Load Local Modules Settings
     * @return array|\Zend\Config\Config
     */
    protected static function _loadLocalModulesConfig()
    {
        return self::fromFiles(glob(self::CONFIG_MODULES_PATTERN), true);
    }

    /**
     * Load Global Settings
     * @return array|\Zend\Config\Config
     */
    protected static function _loadGlobalConfig()
    {
        return self::fromFiles(glob(self::CONFIG_GLOBAL_PATTERN), true);
    }

    /**
     * Load all Modules Settings installed via Composer
     * @return array|\Zend\Config\Config
     */
    protected static function _loadComposerModulesConfig()
    {
        $composerHelper = self::getComposerHelper();
        $installedModules = $composerHelper->getInstalledModules();

        if (count($installedModules)) {
            $settingsArray = array_map(function ($module) {
                if (array_key_exists('path', $module)) {
                    return self::fromFiles(
                        glob($module['path'] . '/' . self::CONFIG_COMPOSER_MODULE_INSTALLED_PATTERN),
                        true
                    );
                }
            }, $installedModules);

            /** @var \Zend\Config\Config $settings */
            $settings = $settingsArray[0];

            if (count($settingsArray) < 1) {
                for ($i = 0; $i <= count($settingsArray); $i++){
                    if ($i != 0) {
                        $settings->merge($settingsArray[$i]);
                    }
                }
            }

            return $settings;
        }

        return [];
    }

    /**
     * @return ComposerHelper
     */
    public static function getComposerHelper()
    {
        if (! self::$_composerHelper) {
            self::$_composerHelper = new ComposerHelper();
        }
        return self::$_composerHelper;
    }

}