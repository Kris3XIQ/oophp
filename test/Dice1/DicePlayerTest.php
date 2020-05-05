<?php

namespace Kris3XIQ\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class Dice1PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dicePlayer = new DicePlayer();
        $this->assertInstanceOf("\Kris3XIQ\Dice1\DicePlayer", $dicePlayer);
    }

    public function testTotalScore()
    {
        $dicePlayer = new DicePlayer();
        $dicePlayer->bank = 50;

        $this->assertEquals(50, $dicePlayer->getTotalScore());
    }

    public function testGetHand()
    {
        $dicePlayer = new DicePlayer();
        $dicePlayer->hand = 25;

        $this->assertEquals(25, $dicePlayer->getHand());
    }

    public function testClearHand()
    {
        $dicePlayer = new DicePlayer();
        $dicePlayer->hand = 25;

        $this->assertEquals(0, $dicePlayer->clearHand());
    }

    public function testBankPoints()
    {
        $dicePlayer = new DicePlayer();
        $dicePlayer->bank = 25;
        $dicePlayer->bankPoints(25);

        $this->assertEquals(50, $dicePlayer->getTotalScore());
    }

    public function testPointsToHand()
    {
        $dicePlayer = new DicePlayer();
        $dicePlayer->hand = 25;
        $dicePlayer->pointsToHand(10);

        $this->assertEquals(35, $dicePlayer->getHand());
    }
}
