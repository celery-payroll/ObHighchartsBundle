<?php

namespace Ob\HighchartsBundle\Tests;

use Nyholm\BundleTest\TestKernel;
use Ob\HighchartsBundle\ObHighchartsBundle;
use Ob\HighchartsBundle\Twig\HighchartsExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class BundleInitializationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /** @var TestKernel $kernel */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(ObHighchartsBundle::class);
        // Add some configuration
        $kernel->addTestConfig(__DIR__.'/Resources/services.yml');
        $kernel->handleOptions($options);

        return $kernel;
    }

    public function testInitBundle()
    {
        // Boot the kernel.
        $kernel = self::bootKernel();

        // Get the container
        $container = $kernel->getContainer();

        // Test if you services exists
        $this->assertTrue($container->has('test.ob_highcharts.twig.highcharts_extension'));
        $service = $container->get('test.ob_highcharts.twig.highcharts_extension');
        $this->assertInstanceOf(HighchartsExtension::class, $service);
    }
}
