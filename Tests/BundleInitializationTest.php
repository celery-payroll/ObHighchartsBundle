<?php

namespace Ob\HighchartsBundle\Tests;

use Nyholm\BundleTest\TestKernel;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Ob\HighchartsBundle\ObHighchartsBundle;
use Ob\HighchartsBundle\Twig\HighchartsExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;
use Twig\TwigFunction;

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
        $kernel->addTestBundle(TwigBundle::class);
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

    /**
     * The twig.extension tag must register chart() as an html-safe function
     */
    public function testChartFunctionIsRegisteredInTwig()
    {
        self::bootKernel();

        /** @var Environment $twig */
        $twig = self::getContainer()->get('twig');

        $this->assertInstanceOf(TwigFunction::class, $twig->getFunction('chart'));

        $output = $twig->createTemplate('{{ chart(c) }}')->render(array('c' => new Highchart()));
        $this->assertStringContainsString('new Highcharts.Chart(', $output);
        $this->assertStringNotContainsString('&quot;', $output);
    }
}
