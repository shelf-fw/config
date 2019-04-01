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
                'type' => 'shelf-module'
            ]
        ]);

        $installedModules = $this->composerHelper->getInstalledModules();

        $this->assertEquals('shelf-module', $installedModules[0]['type']);
        $this->assertSame(
            BP . '/vendor/shelf/example_module',
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
                'type' => 'shelf-module'
            ]
        ]);
        $this->composerHelper->setCheckDirExists(true);
        $installedModules = $this->composerHelper->getInstalledModules();

    }
}