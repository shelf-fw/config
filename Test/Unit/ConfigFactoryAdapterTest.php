<?php

namespace Shelf\Config\Test\Unit;

use PHPUnit\Framework\TestCase;
use Shelf\Config\Composer\ComposerHelper;
use Shelf\Config\ConfigFactoryAdapter;
use Shelf\Config\ConfigInterface;
use Shelf\Dev\Tests\Unit\PHPUnitCommonTrait;

class ConfigFactoryAdapterTest extends TestCase
{
    use PHPUnitCommonTrait;

    /**
     * @var ConfigFactoryAdapter
     */
    protected $configFactory;

    protected function setUp()
    {
        $this->configFactory = new ConfigFactoryAdapter();
    }

    public function testInInstanceOfConfigFactoryInterface()
    {
        $this->assertInstanceOf(ConfigInterface::class, $this->configFactory);
    }

    public function testLocalModulesConfig()
    {
        $localModulesConfig = $this->callMethod(
            $this->configFactory,
            '_loadLocalModulesConfig');

        $this->assertInstanceOf(\Zend\Config\Config::class, $localModulesConfig);
    }

    public function testGlobalConfig()
    {
        $globalConfig = $this->callMethod(
            $this->configFactory,
            '_loadGlobalConfig');

        $this->assertInstanceOf(\Zend\Config\Config::class, $globalConfig);
    }

    public function testGetAllConfig()
    {
        $allConfig = $this->callMethod(
            $this->configFactory,
            'getConfig'
        );

        $this->assertInstanceOf(\Zend\Config\Config::class, $allConfig);
    }

    public function testComposerModulesConfig()
    {
        $configFactory = $this->configFactory;

        $composerHelperMock = $this->getMockBuilder(
            ComposerHelper::class
        )->getMock();

        $composerHelperMock
            ->method('getInstalledModules')
            ->willReturn([
                [
                    'name' => 'shelf/example',
                    'type' => 'shelf_module',
                    'path' => __DIR__ . '/fixtures'
                ]
            ]);

        $configFactory::$_composerHelper = $composerHelperMock;

        $composerConfig = $this->callMethod(
            $configFactory,
            '_loadComposerModulesConfig'
        );

        $this->assertInstanceOf(\Zend\Config\Config::class, $composerConfig);
        $composerConfigArray = $composerConfig->toArray();
        $this->assertEquals('ok', $composerConfigArray['config_composer']);
    }

}