<?php

namespace Shelf\Config\Composer;

/**
 * Class ComposerHelper
 * @package Shelf\Config\Composer
 */
class ComposerHelper implements ComposerHelperInterface
{
    /**
     * @var array
     */
    private $installedModules;

    /**
     * @var array
     */
    private $allPackages;

    /**
     * @var bool
     */
    private $checkDirExists = true;

    /**
     * Get all Shelf Modules Installed via Composer
     * @return array
     */
    public function getInstalledModules()
    {
        if (! $this->installedModules) {
            $allPackages = $this->getAllComposerInstalledPackages();
            $this->installedModules = array_values(array_filter(
                $allPackages,
                function ($package) {
                    if ($package['type'] == self::SHELF_MODULE_TYPE) {
                        return true;
                    }
                }
            ));
        }

        $this->addModulesPath();

        return $this->installedModules;
    }

    /**
     * Get All Composer Installed Packages
     * @return array
     */
    public function getAllComposerInstalledPackages()
    {
        if (! $this->allPackages) {
            $this->allPackages = [];

            if (file_exists(self::JSON_INSTALLED_FILE)) {
                $this->allPackages = json_decode(file_get_contents(self::JSON_INSTALLED_FILE), true);
            }
        }

        return $this->allPackages;
    }

    /**
     * @param array $allPackages
     * @return ComposerHelper
     */
    public function setAllPackages($allPackages)
    {
        $this->allPackages = $allPackages;
        return $this;
    }

    protected function addModulesPath()
    {
        $this->installedModules = array_map(function ($package) {
            $nameExplode = explode('/', $package['name']);
            $path = self::VENDOR_PATH . '/' . $nameExplode[0] . '/' . $nameExplode[1];

            if ($this->isCheckDirExists()) {
                if (! is_dir($path)) {
                    throw new \RuntimeException(
                        'There is a problem with a Shelf module installed via Composer, 
                        its directory does not exist.'
                    );
                }
            }

            $package['path'] = $path;

            return $package;
        }, $this->installedModules);
    }

    /**
     * @return bool
     */
    public function isCheckDirExists()
    {
        return $this->checkDirExists;
    }

    /**
     * @param bool $checkDirExists
     */
    public function setCheckDirExists($checkDirExists)
    {
        $this->checkDirExists = $checkDirExists;
    }
}