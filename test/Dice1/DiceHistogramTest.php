<?php

namespace Kris3XIQ\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class Dice1HistogramTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHistogram = new DiceHistogram();
        $this->assertInstanceOf("\Kris3XIQ\Dice1\DiceHistogram", $diceHistogram);
    }

    public function testGetAsText()
    {
        $diceHistogram = new DiceHistogram();
        $diceHistogram->valuesHistogram = [1, 2, 3, 4, 5, 6];
        $this->assertInternalType("null", $diceHistogram->getAsText());
    }
}
