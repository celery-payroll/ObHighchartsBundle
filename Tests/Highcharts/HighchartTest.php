<?php

namespace Ob\HighchartsBundle\Tests\Highcharts;

use Ob\HighchartsBundle\Highcharts\Highchart;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ExpectDeprecationTrait;

/**
 * This class hold Unit tests for the Highchart Class
 */
class HighchartTest extends TestCase
{
    use ExpectDeprecationTrait;

    /**
     * Render chart using jQuery
     */
    public function testJquery()
    {
        $chart = new Highchart();
        $this->assertMatchesRegularExpression(
            '/\$\(function\s?\(\)\s?\{\n?\r?\s*var chart = new Highcharts.Chart\(\{\n?\r?\s*\}\);\n?\r?\s*\}\);/',
            $chart->render()
        );
    }

    /**
     * Render chart without library wrapper
     */
    public function testNoEngine()
    {
        $chart = new Highchart();
        $this->assertMatchesRegularExpression(
            '/var chart = new Highcharts.Chart\(\{\n?\r?\s*\}\);/',
            $chart->render(null)
        );
    }

    /**
     * Render chart using Mootools
     */
    public function testMooTools()
    {
        $chart = new Highchart();
        $this->assertMatchesRegularExpression(
            '/window.addEvent\(\'domready\', function\s?\(\)\s?\{\r?\n?\s*var chart = new Highcharts.Chart\(\{\n?\r?\s*\}\);\n?\r?\s*\}\);/',
            $chart->render('mootools')
        );
    }

    /**
     * Magic getters and setters
     */
    public function testSetGet()
    {
        $chart = new Highchart();

        $chart->credits->enabled(false);
        $this->assertTrue($chart->credits->enabled == false);

        $chart->credits->enabled(true);
        $this->assertTrue($chart->credits->enabled == true);
    }

    /**
     * Look for that mean trailing comma
     */
    public function testIeFriendliness()
    {
        $chart = new Highchart();

        $chart->chart->setTitle('Am I IE friendly yet?');
        $this->assertMatchesRegularExpression(
            '/\}(?<!,)\n?\r?\s*\}\);\n?\r?\s*\}\);/',
            $chart->render()
        );
    }

    /**
     * Declared chart-level options set through __call must not trigger a deprecation
     */
    public function testDeclaredOptionViaMagicCall()
    {
        $chart = new Highchart();

        $chart->colorAxis(array('min' => 0));
        $this->assertSame(array(array('min' => 0)), $chart->colorAxis);
        $this->assertMatchesRegularExpression('/colorAxis: \{"min":0\}/', $chart->render());
    }

    /**
     * Undeclared options are stored but never rendered, so setting one is deprecated
     *
     * @group legacy
     */
    public function testUndeclaredOptionIsDeprecated()
    {
        $this->expectDeprecation('Since ob/highcharts-bundle 1.7.0.2: Setting the undeclared option "accessibility" on Ob\HighchartsBundle\Highcharts\Highchart is deprecated%S');

        $chart = new Highchart();
        $chart->accessibility(array('enabled' => false));

        $this->assertSame(array(array('enabled' => false)), $chart->accessibility);
        $this->assertStringNotContainsString('accessibility', $chart->render());
    }
}
