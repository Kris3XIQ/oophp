<?php

namespace Kris3XIQ\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class DiceGame
{
    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $players The amount of players a dice game should have,
     *                     defaults to 2 players.
     * 
     */
    //int $players = 2
    public function __construct(int $players = 2) 
    {
        $this->players = [];

        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new DicePlayer();
        }
    }

    public function getPlayer($player) 
    {
        $playerName = array_slice($this->players, $player, 1, true);
        return $playerName;
    }
}
