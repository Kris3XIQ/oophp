<?php

namespace Kris3XIQ\Dice;

use PHPUnit\Framework\TestCase;

/**
 * 
 */
class DiceGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Kris3XIQ\Dice\DiceGame", $diceGame);
    }

    public function testGetPlayer()
    {
        $diceGame = new DiceGame();
        $this->assertInternalType("array", $diceGame->getPlayer(0));
    }
}
