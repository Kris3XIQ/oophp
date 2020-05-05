<?php

namespace Kris3XIQ\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class Create1DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Kris3XIQ\Dice1\Dice", $dice);
    }
}
