<?php

namespace Kris3XIQ\Dice;

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
}
