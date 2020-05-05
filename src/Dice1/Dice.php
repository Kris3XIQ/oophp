<?php

namespace Kris3XIQ\Dice1;

/**
 * Class for creating a single dice object.
 */
class Dice
{
    /**
     * @var int $sides    Number of sides each dice should have,
     *                    defaults to 6.
     */
    public $sides;

    /**
     * Constructor for creating a dice object, defaults to 6
     * sides on a single dice object.
     *
     * @param int $sides  Number of sides each dice should have,
     *                    defaults to 6.
     */
    
    public function __construct(int $sides = 6) 
    {
        $this->sides = $sides;
    }

    /**
     * Roll the dice, returns a random number between 1 and 6,
     * as it defaults to a six sided dice.
     *
     * @return int        Return a random number between 1 and 6.
     */
    public function roll()
    {
        return rand(1, 6);
    }
}
