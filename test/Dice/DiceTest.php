<?php

namespace Kris3XIQ\Dice;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class CreateDiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Kris3XIQ\Dice\Dice", $dice);
    }
}
