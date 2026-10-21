<?php

namespace Ob\HighchartsBundle\Tests\Highstock;

use Ob\HighchartsBundle\Highcharts\Highstock;
use PHPUnit\Framework\TestCase;

class RangeSelectorTest extends TestCase
{
    protected $chart;
    protected $range;

    protected function setUp(): void
    {
        $this->chart = new Highstock();
        $this->range = $this->chart->rangeSelector;
    }

    public function testButtonSpacing()
    {
        $spacing = 0;
        $this->range->buttonSpacing($spacing);
        $this->assertEquals($spacing, $this->range->buttonSpacing);
        $this->assertMatchesRegularExpression('/"buttonSpacing":0/', $this->chart->render());
    }

    public function testButtonTheme()
    {
        $this->markTestIncomplete();
    }

    public function testButtons()
    {
        $buttons = array(array(
            'type' => 'month',
                'count' => 3,
                'text' => '3m'
        ));

        $this->range->buttons($buttons);
        $this->assertEquals($buttons, $this->range->buttons);
        $this->assertMatchesRegularExpression('/"buttons":\[{"type":"month","count":3,"text":"3m"}\]/', $this->chart->render());
    }

    public function testEnabled()
    {
        $this->range->enabled(true);
        $this->assertTrue($this->range->enabled);
        $this->assertMatchesRegularExpression('/"enabled":true/', $this->chart->render());

        $this->range->enabled(false);
        $this->assertFalse($this->range->enabled);
        $this->assertMatchesRegularExpression('/"enabled":false/', $this->chart->render());
    }

    public function testInputBoxBorderColor()
    {
        $color = 'silver';
        $this->range->inputBoxBorderColor($color);
        $this->assertEquals($color, $this->range->inputBoxBorderColor);
        $this->assertMatchesRegularExpression('/"inputBoxBorderColor":"silver"/', $this->chart->render());
    }

    public function testInputBoxHeight()
    {
        $height = 16;
        $this->range->inputBoxHeight($height);
        $this->assertEquals($height, $this->range->inputBoxHeight);
        $this->assertMatchesRegularExpression('/"inputBoxHeight":16/', $this->chart->render());
    }

    public function testInputBoxWidth()
    {
        $width = 16;
        $this->range->inputBoxWidth($width);
        $this->assertEquals($width, $this->range->inputBoxWidth);
        $this->assertMatchesRegularExpression('/"inputBoxWidth":16/', $this->chart->render());
    }

    public function testInputDateFormat()
    {
        $format = '%b %e, %Y';
        $this->range->inputDateFormat($format);
        $this->assertEquals($format, $this->range->inputDateFormat);
        $this->assertMatchesRegularExpression('/"inputDateFormat":"%b %e, %Y"/', $this->chart->render());
    }

    public function testInputDateParser()
    {
        $this->markTestIncomplete();
    }

    public function testInputEditDateFormat()
    {
        $format = '%b %e, %Y';
        $this->range->inputEditDateFormat($format);
        $this->assertEquals($format, $this->range->inputEditDateFormat);
        $this->assertMatchesRegularExpression('/"inputEditDateFormat":"%b %e, %Y"/', $this->chart->render());
    }

    public function testinputEnabled()
    {
        $this->range->inputEnabled(true);
        $this->assertTrue($this->range->inputEnabled);
        $this->assertMatchesRegularExpression('/"inputEnabled":true/', $this->chart->render());

        $this->range->inputEnabled(false);
        $this->assertFalse($this->range->inputEnabled);
        $this->assertMatchesRegularExpression('/"inputEnabled":false/', $this->chart->render());
    }

    public function testInputPosition()
    {
        $position= array(
            'align' => 'right'
        );
        $this->range->position($position);
        $this->assertEquals($position, $this->range->position);
        $this->assertMatchesRegularExpression('/"position":{"align":"right"}/', $this->chart->render());
    }

    public function testInputStyle()
    {
        $this->markTestIncomplete();
    }

    public function testLabelStyle()
    {
        $this->markTestIncomplete();
    }

    public function testSelected()
    {
        $index = 3;
        $this->range->selected($index);
        $this->assertEquals($index, $this->range->selected);
        $this->assertMatchesRegularExpression('/"selected":3/', $this->chart->render());
    }
}
