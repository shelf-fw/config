<?php

namespace Shelf\Config\Test\Unit\Composer;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\CodeCoverage\RuntimeException;
use Shelf\Config\Composer\ComposerHelper;

class ComposerHelperTest extends TestCase
{
    /**
     * @var ComposerHelper
     */
    private $composerHelper;

    protected function setUp()
    {
        $this->composerHelper = new ComposerHelper();
        $this->composerHelper->setCheckDirExists(false);
    }

    public function testGetInstalledModulesIfExists()
    {
        $this->composerHelper->setAllPackages([
            [
                'name' => 'shelf/example_module',
                'type' => 'shelf_module'
            ]
        ]);

        $installedModules = $this->composerHelper->getInstalledModules();

        $this->assertEquals('shelf_module', $installedModules[0]['type']);
        $this->assertSame(
            realpath(__DIR__ . '/../../../Composer') . '/../../../../../vendor/shelf/example_module',
            $installedModules[0]['path']
        );

        $this->composerHelper->setAllPackages(null);
    }

    /**
     * @expectedException RuntimeException
     *
     */
    public function testGetInstalledModulesIfComposerDirectoryNotExists()
    {
        $this->composerHelper->setAllPackages([
            [
                'name' => 'shelf/example_module',
                'type' => 'shelf_module'
            ]
        ]);
        $this->composerHelper->setCheckDirExists(true);
        $installedModules = $this->composerHelper->getInstalledModules();

    }

    public function testGetINstalledModulesIfNotExists()
    {
        $this->composerHelper->setAllPackages(null);

        $this->assertCount(0, $this->composerHelper->getInstalledModules());
    }
}