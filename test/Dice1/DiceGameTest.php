<?php

namespace Kris3XIQ\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class Dice1GameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Kris3XIQ\Dice1\DiceGame", $diceGame);
    }

    public function testGetPlayer()
    {
        $diceGame = new DiceGame();
        $this->assertInternalType("array", $diceGame->getPlayer(0));
    }
}
