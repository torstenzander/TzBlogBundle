<?php
namespace Tz\BlogBundle\Tests\Util;

use Tz\BlogBundle\Util\String;

class StringTest  extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldNormalize()
    {
        $string = String::normalize('Taast test');
        $this->assertEquals('taasttest', $string);
    }

    /**
     * @test
     */
    public function shouldNormalizeUmlaute()
    {
        $string = String::normalize('Täßst Österreich');
        $this->assertEquals('täßstösterreich', $string);
    }

    /**
     * @test
     */
    public function shouldCleanUrl()
    {
        $string = String::cleanForUrl('Mänder Siedchi "s"');
        $this->assertEquals('maender-siedchi-s', $string);
    }

}
