<?php

namespace Kris3XIQ\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class DiceRoll
{
    /**
     * Constructor to initiate the dice rolls.
     *
     * @param int $dices  The amount of dices in play, defaults to 3.
     * 
     * @param int $sum    The total sum of a dice roll, defualts to 0.
     */
    
    public function __construct(int $dices = 3) 
    {
        $this->dices = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[] = new Dice();
        }
        //$this->values[] = $this->rollAllDices();
    }

    /**
     * Get the values from the dices from the last roll.
     * 
     * @return array $values
     */
    public function values()
    {
        return $this->values;
    }

    /**
     * Roll the dice, returns a random number between 1 and 6,
     * as it defaults to a six sided dice.
     *
     * @return void
     */
    public function rollDice() 
    {
        return rand(1, 6);
    }

    /**
     * Roll all the dices and save their values.
     * 
     * @return void-
     */
    public function rollAllDices()
    {
        for ($i = 0; $i < count($this->dices); $i++) {
            array_push($this->values, $this->rollDice());
        }
    }

    /**
     * Check if one of the dices rolled a 1.
     *
     * @return bool
     */
    public function endTurn() 
    {
        return in_array(1, $this->values);
    }

    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sumAllDices() 
    {
        return array_sum($this->values);
    }
}
