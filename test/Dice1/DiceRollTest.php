<?php

namespace Kris3XIQ\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class Dice1RollTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceRoll = new DiceRoll();
        $this->assertInstanceOf("\Kris3XIQ\Dice1\DiceRoll", $diceRoll);

        $this->assertCount(3, $diceRoll->dices);
    }

    public function testValuesAndRollAllDices()
    {
        $diceRoll = new DiceRoll();

        $diceRoll->rollAllDices();
        $this->assertCount(3, $diceRoll->getValues());
        $this->assertCount(3, $diceRoll->getHistogramValues());
    }

    public function testEndTurn()
    {
        $diceRoll = new DiceRoll();

        $diceRoll->rollAllDices();
        $this->assertInternalType("bool", $diceRoll->endTurn());
    }

    public function testSumAllDices()
    {
        $diceRoll = new DiceRoll();

        $diceRoll->rollAllDices();
        $this->assertInternalType("int", $diceRoll->sumAllDices());
    }
}
