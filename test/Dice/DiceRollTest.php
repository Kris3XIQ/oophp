<?php

namespace Kris3XIQ\Dice;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class DiceRollTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceRoll = new DiceRoll();
        $this->assertInstanceOf("\Kris3XIQ\Dice\DiceRoll", $diceRoll);

        $this->assertCount(3, $diceRoll->dices);
        $this->assertCount(0, $diceRoll->values);
    }

    public function testValuesAndRollAllDices()
    {
        $diceRoll = new DiceRoll();

        $diceRoll->rollAllDices();
        $this->assertCount(3, $diceRoll->values());
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
