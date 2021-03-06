<?php

namespace Kris3XIQ\Dice1;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class DiceRoll extends Dice implements DiceHistogramInterface
{
    use DiceHistogramTrait;
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

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[] = new Dice();
        }
    }
        
    /**
     * Roll all the dices and save their values.
     * 
     * @return void
     */
    public function rollAllDices()
    {
        for ($i = 0; $i < count($this->dices); $i++) {
            $roll = parent::roll();
            $this->values[] = $roll;
            $this->valuesHistogram[] = $roll;
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
