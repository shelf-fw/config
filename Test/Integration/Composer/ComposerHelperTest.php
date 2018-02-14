<?php

namespace Shelf\Config\Test\Integration\Composer;

use PHPUnit\Framework\TestCase;
use Shelf\Config\Composer\ComposerHelper;

/**
 * Class ComposerHelperTest
 * @package Shelf\Config\Test\Integration\Composer
 */
class ComposerHelperTest extends TestCase
{
    /**
     * @var ComposerHelper
     */
    private $composerHelper;

    protected function setUp()
    {
        $this->composerHelper = new ComposerHelper();
    }

    public function testGetAllComposerInstalledPackages()
    {
        $allPackages = $this->composerHelper->getAllComposerInstalledPackages();
        $this->assertInternalType('array', $allPackages);
        $this->assertArrayHasKey('type', $allPackages[0], 'Possibly there are no packages installed via Composer');
    }

    public function testGetInstalledModules()
    {

    }
}